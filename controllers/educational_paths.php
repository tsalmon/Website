<?php

function display_educational_path() {
    $cursus_name = params('cursus');
    $path_name   = params('path');

    $cursus = CursusQuery::create()->findOneByShortName($cursus_name);

    if (!$cursus) {
        halt(NOT_FOUND);
    }

    $path = EducationalPathQuery::create()
                ->filterByCursus($cursus)
                ->findOneByShortName($path_name);

    if (!$path) {
        halt(NOT_FOUND);
    }

    // if there is only one educational path for this cursus
    if ($cursus->countEducationalPaths() == 1) {
        redirect_to('/cursus/'.$cursus->getShortName(), array('status' => HTTP_MOVED_PERMANENTLY));
    }

    $cursus_uri = Config::$root_uri.'cursus/'.$cursus->getShortName().'/';
    $base_uri = $cursus_uri.'parcours/'.$path->getShortName().'/';

    $breadcrumbs = array(
        1 => array(
            'href' => $cursus_uri,
            'title' => $cursus->getName()
        ),
        2 => array(
            'href' => $base_uri,
            'title' => $path->getName()
        )
    );

    $courses = array(
        's1' => array(
            'mandatory' => array(),
            'optional'  => array()
        ),
        's2' => array(
            'mandatory' => array(),
            'optional'  => array()
        ),
        // special courses
        's3' => array(
            'mandatory' => array(),
            'optional'  => array()
        )
    );
    
    foreach ($path->getOptionalCourses() as $c) {
        $courses['s'.$c->getSemester()]['optional'] []= array(
            'href' => $cursus_uri.$c->getCode(),
            'title' => $c->getCode()
        );
    }
    
    foreach ($path->getMandatoryCourses() as $c) {
        $courses['s'.$c->getSemester()]['mandatory'] []= array(
            'href' => $cursus_uri.$c->getCode(),
            'title' => $c->getCode()
        );
    }

    $news = array();

    $path_news = NewsQuery::create()
                    ->filterByCursus($cursus)
                    ->filterByDate(array(
                        'max' => time(),
                        'min' => time() - 3600 * 24 * 20
                    ))
                    ->orderByDate('desc')
                    ->limit(10)
                    ->find();
    
    if ($path_news != NULL) {
        foreach ($path_news as $n) {

            $a = $n->getAuthor();
            $author = false;

            if ($a) {
                $author = array(
                    'href' => Config::$root_uri.'p/'.$a->getUsername(),
                    'name' => ($a->getConfigShowRealName() ? $a->getName() : $a->getUsername())
                );
            }

            $news []= array(
                'datetime_attr' => datetime_attr($n->getDate()),
                'datetime'      => date_fr($n->getDate()),
                'title'         => $n->getTitle(),
                'content'       => $n->getText(),
                'author'        => $author
            );
        }
    }

    $other_links = array();

    if ($path->countSchedules() > 0) {
        $other_links []= array(
            'href'  => $base_uri.'emplois-du-temps',
            'title' => 'Emplois du temps'
        );
    }

    $moderation_bar = array();
    $add_news = false;

    if (is_connected() && user()->isModerator()) {
        $moderation_bar []= array(
            'href' => $base_uri.'edit',
            'title' => 'Éditer'
        );

        $add_news = array(
            'href' => $base_uri.'add_news',
            'title' => 'Ajouter une news'
        );
    }

    $resp_q = $path->getResponsable();
    $responsable = false;

    if ($resp_q != null) {
        $responsable = array(
            'href'  => Config::$root_uri.'/p/'.$resp_q->getUsername(),
            'title' => ($resp_q->getConfigShowRealName() ? $resp_q->getName() : $resp_q->getUsername())
        );
    }

    return Config::$tpl->render('cursus/educational_path.html', tpl_array(array(
        'page' => array(
            'title' => $path->getName(),

            'breadcrumb' => $breadcrumbs,

            'news' => $news,

            'cursus' => array(
                'name' => $cursus->getName(),
                'introduction' => $path->getDescription(),

                'path_name' => $path->getName(),

                'courses' => $courses,
                'news' => $news,
                'other_links' => $other_links
            ),

            // moderation
            'moderation_bar' => $moderation_bar,
            'add_news_button' => $add_news

        )
    )));
}

?>

