<?php



/**
 * This class defines the structure of the 'schedules_courses' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.ip7website.map
 */
class SchedulesCoursesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ip7website.map.SchedulesCoursesTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('schedules_courses');
        $this->setPhpName('SchedulesCourses');
        $this->setClassname('SchedulesCourses');
        $this->setPackage('ip7website');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('SCHEDULE_ID', 'ScheduleId', 'INTEGER' , 'schedules', 'ID', true, null, null);
        $this->addForeignPrimaryKey('SCHEDULED_COURSE_ID', 'ScheduledCourseId', 'INTEGER' , 'scheduled_courses', 'ID', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Schedule', 'Schedule', RelationMap::MANY_TO_ONE, array('schedule_id' => 'id', ), 'CASCADE', 'CASCADE');
        $this->addRelation('ScheduledCourse', 'ScheduledCourse', RelationMap::MANY_TO_ONE, array('scheduled_course_id' => 'id', ), 'CASCADE', 'CASCADE');
    } // buildRelations()

} // SchedulesCoursesTableMap
