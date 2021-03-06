<?php

// check if an username already exists,
// and return the response with JSON
function json_check_username() {
    if (!has_get('username')) {
        return json(array('error' => 'no username provided.'));
    }
    $u = get_string('username', 'GET');

    $user = UserQuery::create()->findOneByUsername($u);

    return json(array('data' => ($user ? true : false)));
}

// 
function json_global_search() {
    if (!has_get('q')) {
        return json(array('data' => array()));
    }

    $raw_results = perform_search(escape_mysql_wildcards(get_string('q', 'GET')), false, 5);

    $results = array();

    foreach ($raw_results as $k => $cat_results) {
        foreach ($cat_results['values'] as $_ => $v) {
            $results []= $v;
        }
    }

    return json(array('data' => $results));
}

function json_get_last_contents() {
    $limit = 10;

    if (has_get('l')) {
        $limit = intval($_GET['l']);
    }

    if ($limit <= 0) {
        return json(array('data' => array()));
    }

    $user_rights = is_connected() ? user()->getRank() : 0;

    $contents = ContentQuery::create()
                    ->joinWith('Content.Cursus')
                    ->joinWith('Content.Course')
                    ->filterByValidated(1)
                        ->useContentTypeQuery()
                        ->where('Rights <= ?', $user_rights, PDO::PARAM_INT)
                        ->endUse()
                    ->where('Access_Rights <= ?', $user_rights, PDO::PARAM_INT)
                    ->orderByDate('desc')
                    ->limit($limit)
                    ->find();

    $tpl_contents = array();

    foreach ($contents as $c) {

        $cursus = $c->getCursus();
        $course = $c->getCourse();

        $tpl_contents []= array(
            'href'  => content_url($cursus, $course, $c),
            'title' => $c->getTitle(),
            'date'  => $c->getDate(),

            'cursus' => $cursus ? $cursus->getShortName() : null,
            'course' => $course ? $course->getCode() : null
        );
    }

    return json(array('data' => $tpl_contents));
}

function json_get_news_by_id() {
    $id = intval(get_string('id', 'GET'));
    if (!$id) { return json(array('error' => 'Bad id.')); }

    $user_rights = is_connected() ? user()->getRank() : 0;

    $news = NewsQuery::create()
                ->where('Access_Rights <= ?', $user_rights, PDO::PARAM_INT)
                ->findOneById($id);

    if (!$news) { return json(array('error' => 'Bad id.')); }

    return json(array(
        'data' => array(
            array(
                'title'   => $news->getTitle(),
                'md_text' => $news->getText(),
                'text'    => tpl_render('utils/md.html', array('content'=>$news->getText()))
            )
        )
    ));
}

function json_post_update_news() {
    $id = intval(get_string('id', 'POST'));
    if (!$id) { return json(array('error' => 'Bad id.')); }

    if (!is_connected()) {
        halt(HTTP_FORBIDDEN);
    }

    $news = NewsQuery::create()->findOneById($id);
    if (!$news) { return json(array('error' => 'Bad id.')); }

    $title = get_string('title', 'POST');
    $body  = get_string('body',  'POST');

    $err = check_and_save_news($title, $body, $news);

    if ($err) {
        return $err;
    }

    return json(array(
        'data' => array(
            array(
                'title'   => $news->getTitle(),
                'md_text' => $news->getText(),
                'text'    => tpl_render('utils/md.html', array(
                    'content' => $news->getText()
                ))
            )
        )
    ));
}

function json_post_delete_news() {
    $id = intval(get_string('id', 'POST'));
    if (!$id) { return json(array('error' => 'Bad id.')); }

    if (!is_connected()) {
        halt(HTTP_FORBIDDEN);
    }

    $news = NewsQuery::create()->findOneById($id);
    if (!$news) { return json(array('error' => 'Bad id.')); }

    if ($news->getAccessRights() > user()->getRank()) {
        halt(HTTP_FORBIDDEN);
    }

    if (!user()->isAdmin()) {
        $cursus = $news->getCursus();
        if (!$cursus || !user()->isResponsibleFor($cursus)) {
            halt(HTTP_FORBIDDEN);
        }
    }

    $news->delete();

    return json(array('status' => 'ok'));
}

// post cu_id=<cursus_id>&co_id=<course_id>&title=<title>&text=<text>
function json_post_create_news() {

    $cursus_id = intval(get_string('cu_id', 'POST'));
    $course_id = intval(get_string('co_id', 'POST'));
    $title     = get_string('title', 'POST');
    $text      = get_string('text',  'POST');

    $cursus = ($cursus_id > 0) ? CursusQuery::create()->findOneById($cursus_id) : null;
    $course = ($course_id > 0) ? CourseQuery::create()->findOneById($course_id) : null;

    $news = null;

    $err = check_and_save_news($title, $text, $news, $cursus, $course);

    if ($err) {
        return $err;
    }

    return json(array(
        'data' => array(
            'title'   => $news->getTitle(),
            'md_text' => $news->getText(),
            'text'    => tpl_render('utils/md.html', array(
                'content' => $news->getText()
            )),
            'html'    => tpl_render('utils/one_news.html', array(
                'news' => array(
                    'id'            => $news->getId(),
                    'title'         => $news->getTitle(),
                    'content'       => $news->getText(),
                    'datetime_attr' => datetime_attr($news->getDate()),
                    'datetime'      => Lang\date_fr($news->getDate()),
                    'author'        => array(
                        'href' => Config::$root_uri.'p/'.user()->getUsername(),
                        'name' => user()->getPublicName()
                    )
                )
            ))
        )
    ));
}

function json_get_course_intro() { // ?id=<course id>
    return json_get_description_of_course_or_cursus('course');
}

function json_get_cursus_intro() { // ?id=<cursus id>
    return json_get_description_of_course_or_cursus('cursus');
}

?>
