<?php



/**
 * This class defines the structure of the 'users' table.
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
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ip7website.map.UserTableMap';

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
        $this->setName('users');
        $this->setPhpName('User');
        $this->setClassname('User');
        $this->setPackage('ip7website');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('USERNAME', 'Username', 'VARCHAR', true, 16, null);
        $this->addColumn('PASSWORD_HASH', 'PasswordHash', 'VARCHAR', true, 255, null);
        $this->addColumn('TYPE', 'Type', 'TINYINT', true, null, 0);
        $this->addColumn('FIRSTNAME', 'Firstname', 'VARCHAR', true, 255, null);
        $this->addColumn('LASTNAME', 'Lastname', 'VARCHAR', true, 255, null);
        $this->addColumn('EMAIL', 'Email', 'VARCHAR', true, 255, null);
        $this->addColumn('PHONE', 'Phone', 'VARCHAR', false, 20, null);
        $this->addColumn('ADDRESS', 'Address', 'VARCHAR', false, 255, null);
        $this->addColumn('WEBSITE', 'Website', 'VARCHAR', false, 255, null);
        $this->addColumn('BIRTH_DATE', 'BirthDate', 'DATE', false, null, null);
        $this->addColumn('FIRST_ENTRY', 'FirstEntry', 'DATE', false, null, null);
        $this->addColumn('LAST_ENTRY', 'LastEntry', 'DATE', false, null, null);
        $this->addColumn('LAST_VISIT', 'LastVisit', 'TIMESTAMP', false, null, null);
        $this->addColumn('VISITS_NB', 'VisitsNb', 'INTEGER', false, null, 0);
        $this->addColumn('CONFIG_SHOW_EMAIL', 'ConfigShowEmail', 'BOOLEAN', false, 1, '0');
        $this->addColumn('CONFIG_SHOW_PHONE', 'ConfigShowPhone', 'BOOLEAN', false, 1, '0');
        $this->addColumn('CONFIG_SHOW_REAL_NAME', 'ConfigShowRealName', 'BOOLEAN', false, 1, '1');
        $this->addColumn('DEACTIVATED', 'Deactivated', 'BOOLEAN', false, 1, '0');
        $this->addColumn('IS_A_TEACHER', 'IsATeacher', 'BOOLEAN', false, 1, '0');
        $this->addColumn('IS_A_STUDENT', 'IsAStudent', 'BOOLEAN', false, 1, '1');
        $this->addForeignKey('AVATAR_ID', 'AvatarId', 'INTEGER', 'files', 'ID', false, null, null);
        $this->addColumn('DESCRIPTION', 'Description', 'LONGVARCHAR', false, 512, null);
        $this->addColumn('COMMENTS', 'Comments', 'VARCHAR', false, 255, null);
        // validators
        $this->addValidator('USERNAME', 'minLength', 'propel.validator.MinLengthValidator', '4', 'Username must be at least 4 characters.');
        $this->addValidator('USERNAME', 'match', 'propel.validator.MatchValidator', '/^[a-z](?:[-_]?[a-z0-9]+)+$/i', 'Please enter a valid username.');
        $this->addValidator('USERNAME', 'unique', 'propel.validator.UniqueValidator', '', 'Username already exists.');
        $this->addValidator('FIRSTNAME', 'minLength', 'propel.validator.MinLengthValidator', '1', 'First name must be at least 1 characters.');
        $this->addValidator('LASTNAME', 'minLength', 'propel.validator.MinLengthValidator', '1', 'Last name must be at least 1 characters.');
        $this->addValidator('EMAIL', 'minLength', 'propel.validator.MinLengthValidator', '6', 'Email must be at least 6 characters.');
        $this->addValidator('EMAIL', 'match', 'propel.validator.MatchValidator', '/^[-+\w\.]+@[-\.\w]+\.[a-z]{2,4}$/', 'Please enter a valid email address.');
        $this->addValidator('WEBSITE', 'match', 'propel.validator.MatchValidator', '/^https?/', 'Please use a valid protocol');
        $this->addValidator('VISITS_NB', 'minValue', 'propel.validator.MinValueValidator', '0', 'The number of visits cannot be negative.');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Avatar', 'File', RelationMap::MANY_TO_ONE, array('avatar_id' => 'id', ), 'SET NULL', 'CASCADE');
        $this->addRelation('Cursus', 'Cursus', RelationMap::ONE_TO_MANY, array('id' => 'responsable_id', ), 'SET NULL', 'CASCADE', 'Cursuss');
        $this->addRelation('UsersCursus', 'UsersCursus', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'CASCADE', 'CASCADE', 'UsersCursuss');
        $this->addRelation('FileRelatedByAuthorId', 'File', RelationMap::ONE_TO_MANY, array('id' => 'author_id', ), 'SET NULL', 'CASCADE', 'FilesRelatedByAuthorId');
        $this->addRelation('NewslettersSubscribers', 'NewslettersSubscribers', RelationMap::ONE_TO_MANY, array('id' => 'subscriber_id', ), 'CASCADE', 'CASCADE', 'NewslettersSubscriberss');
        $this->addRelation('Alert', 'Alert', RelationMap::ONE_TO_MANY, array('id' => 'subscriber_id', ), 'CASCADE', 'CASCADE', 'Alerts');
        $this->addRelation('Content', 'Content', RelationMap::ONE_TO_MANY, array('id' => 'author_id', ), 'SET NULL', 'CASCADE', 'Contents');
        $this->addRelation('Comment', 'Comment', RelationMap::ONE_TO_MANY, array('id' => 'author_id', ), 'CASCADE', 'CASCADE', 'Comments');
        $this->addRelation('Report', 'Report', RelationMap::ONE_TO_MANY, array('id' => 'author_id', ), 'SET NULL', 'CASCADE', 'Reports');
        $this->addRelation('Note', 'Note', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'CASCADE', 'CASCADE', 'Notes');
        $this->addRelation('News', 'News', RelationMap::ONE_TO_MANY, array('id' => 'author_id', ), 'SET NULL', 'CASCADE', 'Newss');
        $this->addRelation('Ad', 'Ad', RelationMap::ONE_TO_MANY, array('id' => 'author_id', ), 'CASCADE', 'CASCADE', 'Ads');
        $this->addRelation('Transaction', 'Transaction', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), 'SET NULL', 'CASCADE', 'Transactions');
        $this->addRelation('ForumMessage', 'ForumMessage', RelationMap::ONE_TO_MANY, array('id' => 'author_id', ), 'CASCADE', 'CASCADE', 'ForumMessages');
        $this->addRelation('ScheduledCourse', 'ScheduledCourse', RelationMap::ONE_TO_MANY, array('id' => 'teacher_id', ), 'SET NULL', 'CASCADE', 'ScheduledCourses');
        $this->addRelation('Cursus', 'Cursus', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Cursuss');
        $this->addRelation('Newsletter', 'Newsletter', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Newsletters');
    } // buildRelations()

} // UserTableMap
