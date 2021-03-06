<?php

// Return news (Propel objects)
function get_news($cursus=null, $course=null) {

    $user_rights = is_connected() ? user()->getRank() : 0;

    $q = NewsQuery::create()
                ->where('Access_Rights <= ?', $user_rights, PDO::PARAM_INT)
                ->limit(10)
                ->orderByDate('desc');

    if ($cursus) {
        $q = $q->filterByCursus($cursus);
    }

    if ($course) {
        $q = $q->filterByCourse($course);
    }

    return $q->find();
}

// check if a news is correct (for update/creation)
// returns JSON with an error if not
// if $news is null, it's created and its attributes are set properly
function check_and_save_news($title, $body, &$news, $cursus=null, $course=null) {

    if (!is_connected()) { halt(HTTP_FORBIDDEN); }

    if ($news && $news->getAccessRights() > user()->getRank()) {
        halt(HTTP_FORBIDDEN);
    }

    if ($news) {
        $cursus = $news->getCursus();
        $course = $news->getCourse();
    }

    if ($news && !user()->isAdmin()) {
        if (!$cursus || !user()->isResponsibleFor($cursus)) {
            halt(HTTP_FORBIDDEN);
        }
    }

    if (!$title || strlen($title) > 255)  {
        return json(array('error' => 'Bad title.'));
    }

    if (!$body || strlen($body) > 1024) {
        return json(array('error' => 'Bad body'));
    }

    if (!$news) {
        $news = new News();
        $news->setAuthor(user());
        $news->setDate($_SERVER['REQUEST_TIME']);
        $news->setCursus($cursus);
        $news->setCourse($course);
    }

    $news->setTitle($title);
    $news->setText($body);

    $news->save();

}

?>
