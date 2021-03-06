<?php


/**
 * Base class that represents a row from the 'contents' table.
 *
 *
 *
 * @package    propel.generator.ip7website.om
 */
abstract class BaseContent extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'ContentPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ContentPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the author_id field.
     * @var        int
     */
    protected $author_id;

    /**
     * The value for the content_type_id field.
     * @var        int
     */
    protected $content_type_id;

    /**
     * The value for the date field.
     * @var        string
     */
    protected $date;

    /**
     * The value for the access_rights field.
     * Note: this column has a database default value of: (expression) 0
     * @var        int
     */
    protected $access_rights;

    /**
     * The value for the validated field.
     * Note: this column has a database default value of: (expression) 0
     * @var        boolean
     */
    protected $validated;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the text field.
     * @var        string
     */
    protected $text;

    /**
     * Whether the lazy-loaded $text value has been loaded from database.
     * This is necessary to avoid repeated lookups if $text column is null in the db.
     * @var        boolean
     */
    protected $text_isLoaded = false;

    /**
     * The value for the cursus_id field.
     * @var        int
     */
    protected $cursus_id;

    /**
     * The value for the course_id field.
     * @var        int
     */
    protected $course_id;

    /**
     * The value for the year field.
     * @var        int
     */
    protected $year;

    /**
     * @var        User
     */
    protected $aAuthor;

    /**
     * @var        Cursus
     */
    protected $aCursus;

    /**
     * @var        Course
     */
    protected $aCourse;

    /**
     * @var        ContentType
     */
    protected $aContentType;

    /**
     * @var        PropelObjectCollection|ContentsFiles[] Collection to store aggregation of ContentsFiles objects.
     */
    protected $collContentsFiless;
    protected $collContentsFilessPartial;

    /**
     * @var        PropelObjectCollection|Comment[] Collection to store aggregation of Comment objects.
     */
    protected $collComments;
    protected $collCommentsPartial;

    /**
     * @var        PropelObjectCollection|ContentsTags[] Collection to store aggregation of ContentsTags objects.
     */
    protected $collContentsTagss;
    protected $collContentsTagssPartial;

    /**
     * @var        PropelObjectCollection|Report[] Collection to store aggregation of Report objects.
     */
    protected $collReports;
    protected $collReportsPartial;

    /**
     * @var        PropelObjectCollection|File[] Collection to store aggregation of File objects.
     */
    protected $collFiles;

    /**
     * @var        PropelObjectCollection|Tag[] Collection to store aggregation of Tag objects.
     */
    protected $collTags;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $filesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $tagsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentsFilessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $commentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contentsTagssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $reportsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of BaseContent object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [author_id] column value.
     *
     * @return int
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

    /**
     * Get the [content_type_id] column value.
     *
     * @return int
     */
    public function getContentTypeId()
    {
        return $this->content_type_id;
    }

    /**
     * Get the [optionally formatted] temporal [date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = 'd-m-Y H:i:s')
    {
        if ($this->date === null) {
            return null;
        }

        if ($this->date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        } else {
            try {
                $dt = new DateTime($this->date);
            } catch (Exception $x) {
                throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
            }
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        } elseif (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        } else {
            return $dt->format($format);
        }
    }

    /**
     * Get the [access_rights] column value.
     *
     * @return int
     */
    public function getAccessRights()
    {
        return $this->access_rights;
    }

    /**
     * Get the [validated] column value.
     *
     * @return boolean
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [text] column value.
     *
     * @param PropelPDO $con An optional PropelPDO connection to use for fetching this lazy-loaded column.
     * @return string
     */
    public function getText(PropelPDO $con = null)
    {
        if (!$this->text_isLoaded && $this->text === null && !$this->isNew()) {
            $this->loadText($con);
        }

        return $this->text;
    }

    /**
     * Load the value for the lazy-loaded [text] column.
     *
     * This method performs an additional query to return the value for
     * the [text] column, since it is not populated by
     * the hydrate() method.
     *
     * @param  PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - any underlying error will be wrapped and re-thrown.
     */
    protected function loadText(PropelPDO $con = null)
    {
        $c = $this->buildPkeyCriteria();
        $c->addSelectColumn(ContentPeer::TEXT);
        try {
            $stmt = ContentPeer::doSelectStmt($c, $con);
            $row = $stmt->fetch(PDO::FETCH_NUM);
            $stmt->closeCursor();
            $this->text = ($row[0] !== null) ? (string) $row[0] : null;
            $this->text_isLoaded = true;
        } catch (Exception $e) {
            throw new PropelException("Error loading value for [text] column on demand.", $e);
        }
    }
    /**
     * Get the [cursus_id] column value.
     *
     * @return int
     */
    public function getCursusId()
    {
        return $this->cursus_id;
    }

    /**
     * Get the [course_id] column value.
     *
     * @return int
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Get the [year] column value.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ContentPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [author_id] column.
     *
     * @param int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setAuthorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->author_id !== $v) {
            $this->author_id = $v;
            $this->modifiedColumns[] = ContentPeer::AUTHOR_ID;
        }

        if ($this->aAuthor !== null && $this->aAuthor->getId() !== $v) {
            $this->aAuthor = null;
        }


        return $this;
    } // setAuthorId()

    /**
     * Set the value of [content_type_id] column.
     *
     * @param int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setContentTypeId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->content_type_id !== $v) {
            $this->content_type_id = $v;
            $this->modifiedColumns[] = ContentPeer::CONTENT_TYPE_ID;
        }

        if ($this->aContentType !== null && $this->aContentType->getId() !== $v) {
            $this->aContentType = null;
        }


        return $this;
    } // setContentTypeId()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Content The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            $currentDateAsString = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date = $newDateAsString;
                $this->modifiedColumns[] = ContentPeer::DATE;
            }
        } // if either are not null


        return $this;
    } // setDate()

    /**
     * Set the value of [access_rights] column.
     *
     * @param int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setAccessRights($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->access_rights !== $v) {
            $this->access_rights = $v;
            $this->modifiedColumns[] = ContentPeer::ACCESS_RIGHTS;
        }


        return $this;
    } // setAccessRights()

    /**
     * Sets the value of the [validated] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Content The current object (for fluent API support)
     */
    public function setValidated($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->validated !== $v) {
            $this->validated = $v;
            $this->modifiedColumns[] = ContentPeer::VALIDATED;
        }


        return $this;
    } // setValidated()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = ContentPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [text] column.
     *
     * @param string $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setText($v)
    {
        // explicitly set the is-loaded flag to true for this lazy load col;
        // it doesn't matter if the value is actually set or not (logic below) as
        // any attempt to set the value means that no db lookup should be performed
        // when the getText() method is called.
        $this->text_isLoaded = true;

        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[] = ContentPeer::TEXT;
        }


        return $this;
    } // setText()

    /**
     * Set the value of [cursus_id] column.
     *
     * @param int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setCursusId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cursus_id !== $v) {
            $this->cursus_id = $v;
            $this->modifiedColumns[] = ContentPeer::CURSUS_ID;
        }

        if ($this->aCursus !== null && $this->aCursus->getId() !== $v) {
            $this->aCursus = null;
        }


        return $this;
    } // setCursusId()

    /**
     * Set the value of [course_id] column.
     *
     * @param int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setCourseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->course_id !== $v) {
            $this->course_id = $v;
            $this->modifiedColumns[] = ContentPeer::COURSE_ID;
        }

        if ($this->aCourse !== null && $this->aCourse->getId() !== $v) {
            $this->aCourse = null;
        }


        return $this;
    } // setCourseId()

    /**
     * Set the value of [year] column.
     *
     * @param int $v new value
     * @return Content The current object (for fluent API support)
     */
    public function setYear($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->year !== $v) {
            $this->year = $v;
            $this->modifiedColumns[] = ContentPeer::YEAR;
        }


        return $this;
    } // setYear()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->author_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->content_type_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->date = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->access_rights = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->validated = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
            $this->title = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->cursus_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->course_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->year = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ContentPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Content object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aAuthor !== null && $this->author_id !== $this->aAuthor->getId()) {
            $this->aAuthor = null;
        }
        if ($this->aContentType !== null && $this->content_type_id !== $this->aContentType->getId()) {
            $this->aContentType = null;
        }
        if ($this->aCursus !== null && $this->cursus_id !== $this->aCursus->getId()) {
            $this->aCursus = null;
        }
        if ($this->aCourse !== null && $this->course_id !== $this->aCourse->getId()) {
            $this->aCourse = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ContentPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        // Reset the text lazy-load column
        $this->text = null;
        $this->text_isLoaded = false;

        if ($deep) {  // also de-associate any related objects?

            $this->aAuthor = null;
            $this->aCursus = null;
            $this->aCourse = null;
            $this->aContentType = null;
            $this->collContentsFiless = null;

            $this->collComments = null;

            $this->collContentsTagss = null;

            $this->collReports = null;

            $this->collFiles = null;
            $this->collTags = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ContentQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ContentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ContentPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAuthor !== null) {
                if ($this->aAuthor->isModified() || $this->aAuthor->isNew()) {
                    $affectedRows += $this->aAuthor->save($con);
                }
                $this->setAuthor($this->aAuthor);
            }

            if ($this->aCursus !== null) {
                if ($this->aCursus->isModified() || $this->aCursus->isNew()) {
                    $affectedRows += $this->aCursus->save($con);
                }
                $this->setCursus($this->aCursus);
            }

            if ($this->aCourse !== null) {
                if ($this->aCourse->isModified() || $this->aCourse->isNew()) {
                    $affectedRows += $this->aCourse->save($con);
                }
                $this->setCourse($this->aCourse);
            }

            if ($this->aContentType !== null) {
                if ($this->aContentType->isModified() || $this->aContentType->isNew()) {
                    $affectedRows += $this->aContentType->save($con);
                }
                $this->setContentType($this->aContentType);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->filesScheduledForDeletion !== null) {
                if (!$this->filesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->filesScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($pk, $remotePk);
                    }
                    ContentsFilesQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->filesScheduledForDeletion = null;
                }

                foreach ($this->getFiles() as $file) {
                    if ($file->isModified()) {
                        $file->save($con);
                    }
                }
            }

            if ($this->tagsScheduledForDeletion !== null) {
                if (!$this->tagsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->tagsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($remotePk, $pk);
                    }
                    ContentsTagsQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->tagsScheduledForDeletion = null;
                }

                foreach ($this->getTags() as $tag) {
                    if ($tag->isModified()) {
                        $tag->save($con);
                    }
                }
            }

            if ($this->contentsFilessScheduledForDeletion !== null) {
                if (!$this->contentsFilessScheduledForDeletion->isEmpty()) {
                    ContentsFilesQuery::create()
                        ->filterByPrimaryKeys($this->contentsFilessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentsFilessScheduledForDeletion = null;
                }
            }

            if ($this->collContentsFiless !== null) {
                foreach ($this->collContentsFiless as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->commentsScheduledForDeletion !== null) {
                if (!$this->commentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->commentsScheduledForDeletion as $comment) {
                        // need to save related object because we set the relation to null
                        $comment->save($con);
                    }
                    $this->commentsScheduledForDeletion = null;
                }
            }

            if ($this->collComments !== null) {
                foreach ($this->collComments as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contentsTagssScheduledForDeletion !== null) {
                if (!$this->contentsTagssScheduledForDeletion->isEmpty()) {
                    ContentsTagsQuery::create()
                        ->filterByPrimaryKeys($this->contentsTagssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contentsTagssScheduledForDeletion = null;
                }
            }

            if ($this->collContentsTagss !== null) {
                foreach ($this->collContentsTagss as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->reportsScheduledForDeletion !== null) {
                if (!$this->reportsScheduledForDeletion->isEmpty()) {
                    foreach ($this->reportsScheduledForDeletion as $report) {
                        // need to save related object because we set the relation to null
                        $report->save($con);
                    }
                    $this->reportsScheduledForDeletion = null;
                }
            }

            if ($this->collReports !== null) {
                foreach ($this->collReports as $referrerFK) {
                    if (!$referrerFK->isDeleted()) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = ContentPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ContentPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContentPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`ID`';
        }
        if ($this->isColumnModified(ContentPeer::AUTHOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '`AUTHOR_ID`';
        }
        if ($this->isColumnModified(ContentPeer::CONTENT_TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`CONTENT_TYPE_ID`';
        }
        if ($this->isColumnModified(ContentPeer::DATE)) {
            $modifiedColumns[':p' . $index++]  = '`DATE`';
        }
        if ($this->isColumnModified(ContentPeer::ACCESS_RIGHTS)) {
            $modifiedColumns[':p' . $index++]  = '`ACCESS_RIGHTS`';
        }
        if ($this->isColumnModified(ContentPeer::VALIDATED)) {
            $modifiedColumns[':p' . $index++]  = '`VALIDATED`';
        }
        if ($this->isColumnModified(ContentPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`TITLE`';
        }
        if ($this->isColumnModified(ContentPeer::TEXT)) {
            $modifiedColumns[':p' . $index++]  = '`TEXT`';
        }
        if ($this->isColumnModified(ContentPeer::CURSUS_ID)) {
            $modifiedColumns[':p' . $index++]  = '`CURSUS_ID`';
        }
        if ($this->isColumnModified(ContentPeer::COURSE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`COURSE_ID`';
        }
        if ($this->isColumnModified(ContentPeer::YEAR)) {
            $modifiedColumns[':p' . $index++]  = '`YEAR`';
        }

        $sql = sprintf(
            'INSERT INTO `contents` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`ID`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`AUTHOR_ID`':
                        $stmt->bindValue($identifier, $this->author_id, PDO::PARAM_INT);
                        break;
                    case '`CONTENT_TYPE_ID`':
                        $stmt->bindValue($identifier, $this->content_type_id, PDO::PARAM_INT);
                        break;
                    case '`DATE`':
                        $stmt->bindValue($identifier, $this->date, PDO::PARAM_STR);
                        break;
                    case '`ACCESS_RIGHTS`':
                        $stmt->bindValue($identifier, $this->access_rights, PDO::PARAM_INT);
                        break;
                    case '`VALIDATED`':
                        $stmt->bindValue($identifier, (int) $this->validated, PDO::PARAM_INT);
                        break;
                    case '`TITLE`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`TEXT`':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case '`CURSUS_ID`':
                        $stmt->bindValue($identifier, $this->cursus_id, PDO::PARAM_INT);
                        break;
                    case '`COURSE_ID`':
                        $stmt->bindValue($identifier, $this->course_id, PDO::PARAM_INT);
                        break;
                    case '`YEAR`':
                        $stmt->bindValue($identifier, $this->year, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        } else {
            $this->validationFailures = $res;

            return false;
        }
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aAuthor !== null) {
                if (!$this->aAuthor->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAuthor->getValidationFailures());
                }
            }

            if ($this->aCursus !== null) {
                if (!$this->aCursus->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCursus->getValidationFailures());
                }
            }

            if ($this->aCourse !== null) {
                if (!$this->aCourse->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCourse->getValidationFailures());
                }
            }

            if ($this->aContentType !== null) {
                if (!$this->aContentType->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aContentType->getValidationFailures());
                }
            }


            if (($retval = ContentPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collContentsFiless !== null) {
                    foreach ($this->collContentsFiless as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collComments !== null) {
                    foreach ($this->collComments as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContentsTagss !== null) {
                    foreach ($this->collContentsTagss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collReports !== null) {
                    foreach ($this->collReports as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getAuthorId();
                break;
            case 2:
                return $this->getContentTypeId();
                break;
            case 3:
                return $this->getDate();
                break;
            case 4:
                return $this->getAccessRights();
                break;
            case 5:
                return $this->getValidated();
                break;
            case 6:
                return $this->getTitle();
                break;
            case 7:
                return $this->getText();
                break;
            case 8:
                return $this->getCursusId();
                break;
            case 9:
                return $this->getCourseId();
                break;
            case 10:
                return $this->getYear();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Content'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Content'][$this->getPrimaryKey()] = true;
        $keys = ContentPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getAuthorId(),
            $keys[2] => $this->getContentTypeId(),
            $keys[3] => $this->getDate(),
            $keys[4] => $this->getAccessRights(),
            $keys[5] => $this->getValidated(),
            $keys[6] => $this->getTitle(),
            $keys[7] => ($includeLazyLoadColumns) ? $this->getText() : null,
            $keys[8] => $this->getCursusId(),
            $keys[9] => $this->getCourseId(),
            $keys[10] => $this->getYear(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aAuthor) {
                $result['Author'] = $this->aAuthor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCursus) {
                $result['Cursus'] = $this->aCursus->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCourse) {
                $result['Course'] = $this->aCourse->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aContentType) {
                $result['ContentType'] = $this->aContentType->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collContentsFiless) {
                $result['ContentsFiless'] = $this->collContentsFiless->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collComments) {
                $result['Comments'] = $this->collComments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContentsTagss) {
                $result['ContentsTagss'] = $this->collContentsTagss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collReports) {
                $result['Reports'] = $this->collReports->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ContentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setAuthorId($value);
                break;
            case 2:
                $this->setContentTypeId($value);
                break;
            case 3:
                $this->setDate($value);
                break;
            case 4:
                $this->setAccessRights($value);
                break;
            case 5:
                $this->setValidated($value);
                break;
            case 6:
                $this->setTitle($value);
                break;
            case 7:
                $this->setText($value);
                break;
            case 8:
                $this->setCursusId($value);
                break;
            case 9:
                $this->setCourseId($value);
                break;
            case 10:
                $this->setYear($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ContentPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAuthorId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setContentTypeId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDate($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAccessRights($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setValidated($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setTitle($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setText($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setCursusId($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setCourseId($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setYear($arr[$keys[10]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ContentPeer::DATABASE_NAME);

        if ($this->isColumnModified(ContentPeer::ID)) $criteria->add(ContentPeer::ID, $this->id);
        if ($this->isColumnModified(ContentPeer::AUTHOR_ID)) $criteria->add(ContentPeer::AUTHOR_ID, $this->author_id);
        if ($this->isColumnModified(ContentPeer::CONTENT_TYPE_ID)) $criteria->add(ContentPeer::CONTENT_TYPE_ID, $this->content_type_id);
        if ($this->isColumnModified(ContentPeer::DATE)) $criteria->add(ContentPeer::DATE, $this->date);
        if ($this->isColumnModified(ContentPeer::ACCESS_RIGHTS)) $criteria->add(ContentPeer::ACCESS_RIGHTS, $this->access_rights);
        if ($this->isColumnModified(ContentPeer::VALIDATED)) $criteria->add(ContentPeer::VALIDATED, $this->validated);
        if ($this->isColumnModified(ContentPeer::TITLE)) $criteria->add(ContentPeer::TITLE, $this->title);
        if ($this->isColumnModified(ContentPeer::TEXT)) $criteria->add(ContentPeer::TEXT, $this->text);
        if ($this->isColumnModified(ContentPeer::CURSUS_ID)) $criteria->add(ContentPeer::CURSUS_ID, $this->cursus_id);
        if ($this->isColumnModified(ContentPeer::COURSE_ID)) $criteria->add(ContentPeer::COURSE_ID, $this->course_id);
        if ($this->isColumnModified(ContentPeer::YEAR)) $criteria->add(ContentPeer::YEAR, $this->year);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ContentPeer::DATABASE_NAME);
        $criteria->add(ContentPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Content (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAuthorId($this->getAuthorId());
        $copyObj->setContentTypeId($this->getContentTypeId());
        $copyObj->setDate($this->getDate());
        $copyObj->setAccessRights($this->getAccessRights());
        $copyObj->setValidated($this->getValidated());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setText($this->getText());
        $copyObj->setCursusId($this->getCursusId());
        $copyObj->setCourseId($this->getCourseId());
        $copyObj->setYear($this->getYear());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getContentsFiless() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentsFiles($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getComments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addComment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContentsTagss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContentsTags($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getReports() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addReport($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Content Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return ContentPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ContentPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param             User $v
     * @return Content The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAuthor(User $v = null)
    {
        if ($v === null) {
            $this->setAuthorId(NULL);
        } else {
            $this->setAuthorId($v->getId());
        }

        $this->aAuthor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addContent($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getAuthor(PropelPDO $con = null)
    {
        if ($this->aAuthor === null && ($this->author_id !== null)) {
            $this->aAuthor = UserQuery::create()->findPk($this->author_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAuthor->addContents($this);
             */
        }

        return $this->aAuthor;
    }

    /**
     * Declares an association between this object and a Cursus object.
     *
     * @param             Cursus $v
     * @return Content The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCursus(Cursus $v = null)
    {
        if ($v === null) {
            $this->setCursusId(NULL);
        } else {
            $this->setCursusId($v->getId());
        }

        $this->aCursus = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cursus object, it will not be re-added.
        if ($v !== null) {
            $v->addContent($this);
        }


        return $this;
    }


    /**
     * Get the associated Cursus object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return Cursus The associated Cursus object.
     * @throws PropelException
     */
    public function getCursus(PropelPDO $con = null)
    {
        if ($this->aCursus === null && ($this->cursus_id !== null)) {
            $this->aCursus = CursusQuery::create()->findPk($this->cursus_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCursus->addContents($this);
             */
        }

        return $this->aCursus;
    }

    /**
     * Declares an association between this object and a Course object.
     *
     * @param             Course $v
     * @return Content The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCourse(Course $v = null)
    {
        if ($v === null) {
            $this->setCourseId(NULL);
        } else {
            $this->setCourseId($v->getId());
        }

        $this->aCourse = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Course object, it will not be re-added.
        if ($v !== null) {
            $v->addContent($this);
        }


        return $this;
    }


    /**
     * Get the associated Course object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return Course The associated Course object.
     * @throws PropelException
     */
    public function getCourse(PropelPDO $con = null)
    {
        if ($this->aCourse === null && ($this->course_id !== null)) {
            $this->aCourse = CourseQuery::create()->findPk($this->course_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCourse->addContents($this);
             */
        }

        return $this->aCourse;
    }

    /**
     * Declares an association between this object and a ContentType object.
     *
     * @param             ContentType $v
     * @return Content The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContentType(ContentType $v = null)
    {
        if ($v === null) {
            $this->setContentTypeId(NULL);
        } else {
            $this->setContentTypeId($v->getId());
        }

        $this->aContentType = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ContentType object, it will not be re-added.
        if ($v !== null) {
            $v->addContent($this);
        }


        return $this;
    }


    /**
     * Get the associated ContentType object
     *
     * @param PropelPDO $con Optional Connection object.
     * @return ContentType The associated ContentType object.
     * @throws PropelException
     */
    public function getContentType(PropelPDO $con = null)
    {
        if ($this->aContentType === null && ($this->content_type_id !== null)) {
            $this->aContentType = ContentTypeQuery::create()->findPk($this->content_type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContentType->addContents($this);
             */
        }

        return $this->aContentType;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ContentsFiles' == $relationName) {
            $this->initContentsFiless();
        }
        if ('Comment' == $relationName) {
            $this->initComments();
        }
        if ('ContentsTags' == $relationName) {
            $this->initContentsTagss();
        }
        if ('Report' == $relationName) {
            $this->initReports();
        }
    }

    /**
     * Clears out the collContentsFiless collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContentsFiless()
     */
    public function clearContentsFiless()
    {
        $this->collContentsFiless = null; // important to set this to null since that means it is uninitialized
        $this->collContentsFilessPartial = null;
    }

    /**
     * reset is the collContentsFiless collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentsFiless($v = true)
    {
        $this->collContentsFilessPartial = $v;
    }

    /**
     * Initializes the collContentsFiless collection.
     *
     * By default this just sets the collContentsFiless collection to an empty array (like clearcollContentsFiless());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentsFiless($overrideExisting = true)
    {
        if (null !== $this->collContentsFiless && !$overrideExisting) {
            return;
        }
        $this->collContentsFiless = new PropelObjectCollection();
        $this->collContentsFiless->setModel('ContentsFiles');
    }

    /**
     * Gets an array of ContentsFiles objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentsFiles[] List of ContentsFiles objects
     * @throws PropelException
     */
    public function getContentsFiless($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentsFilessPartial && !$this->isNew();
        if (null === $this->collContentsFiless || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentsFiless) {
                // return empty collection
                $this->initContentsFiless();
            } else {
                $collContentsFiless = ContentsFilesQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentsFilessPartial && count($collContentsFiless)) {
                      $this->initContentsFiless(false);

                      foreach($collContentsFiless as $obj) {
                        if (false == $this->collContentsFiless->contains($obj)) {
                          $this->collContentsFiless->append($obj);
                        }
                      }

                      $this->collContentsFilessPartial = true;
                    }

                    return $collContentsFiless;
                }

                if($partial && $this->collContentsFiless) {
                    foreach($this->collContentsFiless as $obj) {
                        if($obj->isNew()) {
                            $collContentsFiless[] = $obj;
                        }
                    }
                }

                $this->collContentsFiless = $collContentsFiless;
                $this->collContentsFilessPartial = false;
            }
        }

        return $this->collContentsFiless;
    }

    /**
     * Sets a collection of ContentsFiles objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentsFiless A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setContentsFiless(PropelCollection $contentsFiless, PropelPDO $con = null)
    {
        $this->contentsFilessScheduledForDeletion = $this->getContentsFiless(new Criteria(), $con)->diff($contentsFiless);

        foreach ($this->contentsFilessScheduledForDeletion as $contentsFilesRemoved) {
            $contentsFilesRemoved->setContent(null);
        }

        $this->collContentsFiless = null;
        foreach ($contentsFiless as $contentsFiles) {
            $this->addContentsFiles($contentsFiles);
        }

        $this->collContentsFiless = $contentsFiless;
        $this->collContentsFilessPartial = false;
    }

    /**
     * Returns the number of related ContentsFiles objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentsFiles objects.
     * @throws PropelException
     */
    public function countContentsFiless(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentsFilessPartial && !$this->isNew();
        if (null === $this->collContentsFiless || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentsFiless) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getContentsFiless());
                }
                $query = ContentsFilesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContent($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentsFiless);
        }
    }

    /**
     * Method called to associate a ContentsFiles object to this object
     * through the ContentsFiles foreign key attribute.
     *
     * @param    ContentsFiles $l ContentsFiles
     * @return Content The current object (for fluent API support)
     */
    public function addContentsFiles(ContentsFiles $l)
    {
        if ($this->collContentsFiless === null) {
            $this->initContentsFiless();
            $this->collContentsFilessPartial = true;
        }
        if (!$this->collContentsFiless->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddContentsFiles($l);
        }

        return $this;
    }

    /**
     * @param	ContentsFiles $contentsFiles The contentsFiles object to add.
     */
    protected function doAddContentsFiles($contentsFiles)
    {
        $this->collContentsFiless[]= $contentsFiles;
        $contentsFiles->setContent($this);
    }

    /**
     * @param	ContentsFiles $contentsFiles The contentsFiles object to remove.
     */
    public function removeContentsFiles($contentsFiles)
    {
        if ($this->getContentsFiless()->contains($contentsFiles)) {
            $this->collContentsFiless->remove($this->collContentsFiless->search($contentsFiles));
            if (null === $this->contentsFilessScheduledForDeletion) {
                $this->contentsFilessScheduledForDeletion = clone $this->collContentsFiless;
                $this->contentsFilessScheduledForDeletion->clear();
            }
            $this->contentsFilessScheduledForDeletion[]= $contentsFiles;
            $contentsFiles->setContent(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Content is new, it will return
     * an empty collection; or if this Content has previously
     * been saved, it will retrieve related ContentsFiless from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Content.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentsFiles[] List of ContentsFiles objects
     */
    public function getContentsFilessJoinFile($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentsFilesQuery::create(null, $criteria);
        $query->joinWith('File', $join_behavior);

        return $this->getContentsFiless($query, $con);
    }

    /**
     * Clears out the collComments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addComments()
     */
    public function clearComments()
    {
        $this->collComments = null; // important to set this to null since that means it is uninitialized
        $this->collCommentsPartial = null;
    }

    /**
     * reset is the collComments collection loaded partially
     *
     * @return void
     */
    public function resetPartialComments($v = true)
    {
        $this->collCommentsPartial = $v;
    }

    /**
     * Initializes the collComments collection.
     *
     * By default this just sets the collComments collection to an empty array (like clearcollComments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initComments($overrideExisting = true)
    {
        if (null !== $this->collComments && !$overrideExisting) {
            return;
        }
        $this->collComments = new PropelObjectCollection();
        $this->collComments->setModel('Comment');
    }

    /**
     * Gets an array of Comment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Comment[] List of Comment objects
     * @throws PropelException
     */
    public function getComments($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                // return empty collection
                $this->initComments();
            } else {
                $collComments = CommentQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCommentsPartial && count($collComments)) {
                      $this->initComments(false);

                      foreach($collComments as $obj) {
                        if (false == $this->collComments->contains($obj)) {
                          $this->collComments->append($obj);
                        }
                      }

                      $this->collCommentsPartial = true;
                    }

                    return $collComments;
                }

                if($partial && $this->collComments) {
                    foreach($this->collComments as $obj) {
                        if($obj->isNew()) {
                            $collComments[] = $obj;
                        }
                    }
                }

                $this->collComments = $collComments;
                $this->collCommentsPartial = false;
            }
        }

        return $this->collComments;
    }

    /**
     * Sets a collection of Comment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $comments A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setComments(PropelCollection $comments, PropelPDO $con = null)
    {
        $this->commentsScheduledForDeletion = $this->getComments(new Criteria(), $con)->diff($comments);

        foreach ($this->commentsScheduledForDeletion as $commentRemoved) {
            $commentRemoved->setContent(null);
        }

        $this->collComments = null;
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }

        $this->collComments = $comments;
        $this->collCommentsPartial = false;
    }

    /**
     * Returns the number of related Comment objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Comment objects.
     * @throws PropelException
     */
    public function countComments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCommentsPartial && !$this->isNew();
        if (null === $this->collComments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collComments) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getComments());
                }
                $query = CommentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContent($this)
                    ->count($con);
            }
        } else {
            return count($this->collComments);
        }
    }

    /**
     * Method called to associate a Comment object to this object
     * through the Comment foreign key attribute.
     *
     * @param    Comment $l Comment
     * @return Content The current object (for fluent API support)
     */
    public function addComment(Comment $l)
    {
        if ($this->collComments === null) {
            $this->initComments();
            $this->collCommentsPartial = true;
        }
        if (!$this->collComments->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddComment($l);
        }

        return $this;
    }

    /**
     * @param	Comment $comment The comment object to add.
     */
    protected function doAddComment($comment)
    {
        $this->collComments[]= $comment;
        $comment->setContent($this);
    }

    /**
     * @param	Comment $comment The comment object to remove.
     */
    public function removeComment($comment)
    {
        if ($this->getComments()->contains($comment)) {
            $this->collComments->remove($this->collComments->search($comment));
            if (null === $this->commentsScheduledForDeletion) {
                $this->commentsScheduledForDeletion = clone $this->collComments;
                $this->commentsScheduledForDeletion->clear();
            }
            $this->commentsScheduledForDeletion[]= $comment;
            $comment->setContent(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Content is new, it will return
     * an empty collection; or if this Content has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Content.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Comment[] List of Comment objects
     */
    public function getCommentsJoinReplyToComment($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CommentQuery::create(null, $criteria);
        $query->joinWith('ReplyToComment', $join_behavior);

        return $this->getComments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Content is new, it will return
     * an empty collection; or if this Content has previously
     * been saved, it will retrieve related Comments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Content.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Comment[] List of Comment objects
     */
    public function getCommentsJoinAuthor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CommentQuery::create(null, $criteria);
        $query->joinWith('Author', $join_behavior);

        return $this->getComments($query, $con);
    }

    /**
     * Clears out the collContentsTagss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContentsTagss()
     */
    public function clearContentsTagss()
    {
        $this->collContentsTagss = null; // important to set this to null since that means it is uninitialized
        $this->collContentsTagssPartial = null;
    }

    /**
     * reset is the collContentsTagss collection loaded partially
     *
     * @return void
     */
    public function resetPartialContentsTagss($v = true)
    {
        $this->collContentsTagssPartial = $v;
    }

    /**
     * Initializes the collContentsTagss collection.
     *
     * By default this just sets the collContentsTagss collection to an empty array (like clearcollContentsTagss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContentsTagss($overrideExisting = true)
    {
        if (null !== $this->collContentsTagss && !$overrideExisting) {
            return;
        }
        $this->collContentsTagss = new PropelObjectCollection();
        $this->collContentsTagss->setModel('ContentsTags');
    }

    /**
     * Gets an array of ContentsTags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContentsTags[] List of ContentsTags objects
     * @throws PropelException
     */
    public function getContentsTagss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContentsTagssPartial && !$this->isNew();
        if (null === $this->collContentsTagss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContentsTagss) {
                // return empty collection
                $this->initContentsTagss();
            } else {
                $collContentsTagss = ContentsTagsQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContentsTagssPartial && count($collContentsTagss)) {
                      $this->initContentsTagss(false);

                      foreach($collContentsTagss as $obj) {
                        if (false == $this->collContentsTagss->contains($obj)) {
                          $this->collContentsTagss->append($obj);
                        }
                      }

                      $this->collContentsTagssPartial = true;
                    }

                    return $collContentsTagss;
                }

                if($partial && $this->collContentsTagss) {
                    foreach($this->collContentsTagss as $obj) {
                        if($obj->isNew()) {
                            $collContentsTagss[] = $obj;
                        }
                    }
                }

                $this->collContentsTagss = $collContentsTagss;
                $this->collContentsTagssPartial = false;
            }
        }

        return $this->collContentsTagss;
    }

    /**
     * Sets a collection of ContentsTags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contentsTagss A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setContentsTagss(PropelCollection $contentsTagss, PropelPDO $con = null)
    {
        $this->contentsTagssScheduledForDeletion = $this->getContentsTagss(new Criteria(), $con)->diff($contentsTagss);

        foreach ($this->contentsTagssScheduledForDeletion as $contentsTagsRemoved) {
            $contentsTagsRemoved->setContent(null);
        }

        $this->collContentsTagss = null;
        foreach ($contentsTagss as $contentsTags) {
            $this->addContentsTags($contentsTags);
        }

        $this->collContentsTagss = $contentsTagss;
        $this->collContentsTagssPartial = false;
    }

    /**
     * Returns the number of related ContentsTags objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContentsTags objects.
     * @throws PropelException
     */
    public function countContentsTagss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContentsTagssPartial && !$this->isNew();
        if (null === $this->collContentsTagss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContentsTagss) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getContentsTagss());
                }
                $query = ContentsTagsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContent($this)
                    ->count($con);
            }
        } else {
            return count($this->collContentsTagss);
        }
    }

    /**
     * Method called to associate a ContentsTags object to this object
     * through the ContentsTags foreign key attribute.
     *
     * @param    ContentsTags $l ContentsTags
     * @return Content The current object (for fluent API support)
     */
    public function addContentsTags(ContentsTags $l)
    {
        if ($this->collContentsTagss === null) {
            $this->initContentsTagss();
            $this->collContentsTagssPartial = true;
        }
        if (!$this->collContentsTagss->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddContentsTags($l);
        }

        return $this;
    }

    /**
     * @param	ContentsTags $contentsTags The contentsTags object to add.
     */
    protected function doAddContentsTags($contentsTags)
    {
        $this->collContentsTagss[]= $contentsTags;
        $contentsTags->setContent($this);
    }

    /**
     * @param	ContentsTags $contentsTags The contentsTags object to remove.
     */
    public function removeContentsTags($contentsTags)
    {
        if ($this->getContentsTagss()->contains($contentsTags)) {
            $this->collContentsTagss->remove($this->collContentsTagss->search($contentsTags));
            if (null === $this->contentsTagssScheduledForDeletion) {
                $this->contentsTagssScheduledForDeletion = clone $this->collContentsTagss;
                $this->contentsTagssScheduledForDeletion->clear();
            }
            $this->contentsTagssScheduledForDeletion[]= $contentsTags;
            $contentsTags->setContent(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Content is new, it will return
     * an empty collection; or if this Content has previously
     * been saved, it will retrieve related ContentsTagss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Content.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContentsTags[] List of ContentsTags objects
     */
    public function getContentsTagssJoinTag($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContentsTagsQuery::create(null, $criteria);
        $query->joinWith('Tag', $join_behavior);

        return $this->getContentsTagss($query, $con);
    }

    /**
     * Clears out the collReports collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addReports()
     */
    public function clearReports()
    {
        $this->collReports = null; // important to set this to null since that means it is uninitialized
        $this->collReportsPartial = null;
    }

    /**
     * reset is the collReports collection loaded partially
     *
     * @return void
     */
    public function resetPartialReports($v = true)
    {
        $this->collReportsPartial = $v;
    }

    /**
     * Initializes the collReports collection.
     *
     * By default this just sets the collReports collection to an empty array (like clearcollReports());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initReports($overrideExisting = true)
    {
        if (null !== $this->collReports && !$overrideExisting) {
            return;
        }
        $this->collReports = new PropelObjectCollection();
        $this->collReports->setModel('Report');
    }

    /**
     * Gets an array of Report objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Report[] List of Report objects
     * @throws PropelException
     */
    public function getReports($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collReportsPartial && !$this->isNew();
        if (null === $this->collReports || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collReports) {
                // return empty collection
                $this->initReports();
            } else {
                $collReports = ReportQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collReportsPartial && count($collReports)) {
                      $this->initReports(false);

                      foreach($collReports as $obj) {
                        if (false == $this->collReports->contains($obj)) {
                          $this->collReports->append($obj);
                        }
                      }

                      $this->collReportsPartial = true;
                    }

                    return $collReports;
                }

                if($partial && $this->collReports) {
                    foreach($this->collReports as $obj) {
                        if($obj->isNew()) {
                            $collReports[] = $obj;
                        }
                    }
                }

                $this->collReports = $collReports;
                $this->collReportsPartial = false;
            }
        }

        return $this->collReports;
    }

    /**
     * Sets a collection of Report objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $reports A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setReports(PropelCollection $reports, PropelPDO $con = null)
    {
        $this->reportsScheduledForDeletion = $this->getReports(new Criteria(), $con)->diff($reports);

        foreach ($this->reportsScheduledForDeletion as $reportRemoved) {
            $reportRemoved->setContent(null);
        }

        $this->collReports = null;
        foreach ($reports as $report) {
            $this->addReport($report);
        }

        $this->collReports = $reports;
        $this->collReportsPartial = false;
    }

    /**
     * Returns the number of related Report objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Report objects.
     * @throws PropelException
     */
    public function countReports(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collReportsPartial && !$this->isNew();
        if (null === $this->collReports || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collReports) {
                return 0;
            } else {
                if($partial && !$criteria) {
                    return count($this->getReports());
                }
                $query = ReportQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContent($this)
                    ->count($con);
            }
        } else {
            return count($this->collReports);
        }
    }

    /**
     * Method called to associate a Report object to this object
     * through the Report foreign key attribute.
     *
     * @param    Report $l Report
     * @return Content The current object (for fluent API support)
     */
    public function addReport(Report $l)
    {
        if ($this->collReports === null) {
            $this->initReports();
            $this->collReportsPartial = true;
        }
        if (!$this->collReports->contains($l)) { // only add it if the **same** object is not already associated
            $this->doAddReport($l);
        }

        return $this;
    }

    /**
     * @param	Report $report The report object to add.
     */
    protected function doAddReport($report)
    {
        $this->collReports[]= $report;
        $report->setContent($this);
    }

    /**
     * @param	Report $report The report object to remove.
     */
    public function removeReport($report)
    {
        if ($this->getReports()->contains($report)) {
            $this->collReports->remove($this->collReports->search($report));
            if (null === $this->reportsScheduledForDeletion) {
                $this->reportsScheduledForDeletion = clone $this->collReports;
                $this->reportsScheduledForDeletion->clear();
            }
            $this->reportsScheduledForDeletion[]= $report;
            $report->setContent(null);
        }
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Content is new, it will return
     * an empty collection; or if this Content has previously
     * been saved, it will retrieve related Reports from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Content.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Report[] List of Report objects
     */
    public function getReportsJoinAuthor($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ReportQuery::create(null, $criteria);
        $query->joinWith('Author', $join_behavior);

        return $this->getReports($query, $con);
    }

    /**
     * Clears out the collFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFiles()
     */
    public function clearFiles()
    {
        $this->collFiles = null; // important to set this to null since that means it is uninitialized
        $this->collFilesPartial = null;
    }

    /**
     * Initializes the collFiles collection.
     *
     * By default this just sets the collFiles collection to an empty collection (like clearFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initFiles()
    {
        $this->collFiles = new PropelObjectCollection();
        $this->collFiles->setModel('File');
    }

    /**
     * Gets a collection of File objects related by a many-to-many relationship
     * to the current object by way of the contents_files cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|File[] List of File objects
     */
    public function getFiles($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collFiles || null !== $criteria) {
            if ($this->isNew() && null === $this->collFiles) {
                // return empty collection
                $this->initFiles();
            } else {
                $collFiles = FileQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collFiles;
                }
                $this->collFiles = $collFiles;
            }
        }

        return $this->collFiles;
    }

    /**
     * Sets a collection of File objects related by a many-to-many relationship
     * to the current object by way of the contents_files cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $files A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setFiles(PropelCollection $files, PropelPDO $con = null)
    {
        $this->clearFiles();
        $currentFiles = $this->getFiles();

        $this->filesScheduledForDeletion = $currentFiles->diff($files);

        foreach ($files as $file) {
            if (!$currentFiles->contains($file)) {
                $this->doAddFile($file);
            }
        }

        $this->collFiles = $files;
    }

    /**
     * Gets the number of File objects related by a many-to-many relationship
     * to the current object by way of the contents_files cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related File objects
     */
    public function countFiles($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collFiles || null !== $criteria) {
            if ($this->isNew() && null === $this->collFiles) {
                return 0;
            } else {
                $query = FileQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContent($this)
                    ->count($con);
            }
        } else {
            return count($this->collFiles);
        }
    }

    /**
     * Associate a File object to this object
     * through the contents_files cross reference table.
     *
     * @param  File $file The ContentsFiles object to relate
     * @return void
     */
    public function addFile(File $file)
    {
        if ($this->collFiles === null) {
            $this->initFiles();
        }
        if (!$this->collFiles->contains($file)) { // only add it if the **same** object is not already associated
            $this->doAddFile($file);

            $this->collFiles[]= $file;
        }
    }

    /**
     * @param	File $file The file object to add.
     */
    protected function doAddFile($file)
    {
        $contentsFiles = new ContentsFiles();
        $contentsFiles->setFile($file);
        $this->addContentsFiles($contentsFiles);
    }

    /**
     * Remove a File object to this object
     * through the contents_files cross reference table.
     *
     * @param File $file The ContentsFiles object to relate
     * @return void
     */
    public function removeFile(File $file)
    {
        if ($this->getFiles()->contains($file)) {
            $this->collFiles->remove($this->collFiles->search($file));
            if (null === $this->filesScheduledForDeletion) {
                $this->filesScheduledForDeletion = clone $this->collFiles;
                $this->filesScheduledForDeletion->clear();
            }
            $this->filesScheduledForDeletion[]= $file;
        }
    }

    /**
     * Clears out the collTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTags()
     */
    public function clearTags()
    {
        $this->collTags = null; // important to set this to null since that means it is uninitialized
        $this->collTagsPartial = null;
    }

    /**
     * Initializes the collTags collection.
     *
     * By default this just sets the collTags collection to an empty collection (like clearTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTags()
    {
        $this->collTags = new PropelObjectCollection();
        $this->collTags->setModel('Tag');
    }

    /**
     * Gets a collection of Tag objects related by a many-to-many relationship
     * to the current object by way of the contents_tags cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Content is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|Tag[] List of Tag objects
     */
    public function getTags($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collTags || null !== $criteria) {
            if ($this->isNew() && null === $this->collTags) {
                // return empty collection
                $this->initTags();
            } else {
                $collTags = TagQuery::create(null, $criteria)
                    ->filterByContent($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collTags;
                }
                $this->collTags = $collTags;
            }
        }

        return $this->collTags;
    }

    /**
     * Sets a collection of Tag objects related by a many-to-many relationship
     * to the current object by way of the contents_tags cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $tags A Propel collection.
     * @param PropelPDO $con Optional connection object
     */
    public function setTags(PropelCollection $tags, PropelPDO $con = null)
    {
        $this->clearTags();
        $currentTags = $this->getTags();

        $this->tagsScheduledForDeletion = $currentTags->diff($tags);

        foreach ($tags as $tag) {
            if (!$currentTags->contains($tag)) {
                $this->doAddTag($tag);
            }
        }

        $this->collTags = $tags;
    }

    /**
     * Gets the number of Tag objects related by a many-to-many relationship
     * to the current object by way of the contents_tags cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related Tag objects
     */
    public function countTags($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collTags || null !== $criteria) {
            if ($this->isNew() && null === $this->collTags) {
                return 0;
            } else {
                $query = TagQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByContent($this)
                    ->count($con);
            }
        } else {
            return count($this->collTags);
        }
    }

    /**
     * Associate a Tag object to this object
     * through the contents_tags cross reference table.
     *
     * @param  Tag $tag The ContentsTags object to relate
     * @return void
     */
    public function addTag(Tag $tag)
    {
        if ($this->collTags === null) {
            $this->initTags();
        }
        if (!$this->collTags->contains($tag)) { // only add it if the **same** object is not already associated
            $this->doAddTag($tag);

            $this->collTags[]= $tag;
        }
    }

    /**
     * @param	Tag $tag The tag object to add.
     */
    protected function doAddTag($tag)
    {
        $contentsTags = new ContentsTags();
        $contentsTags->setTag($tag);
        $this->addContentsTags($contentsTags);
    }

    /**
     * Remove a Tag object to this object
     * through the contents_tags cross reference table.
     *
     * @param Tag $tag The ContentsTags object to relate
     * @return void
     */
    public function removeTag(Tag $tag)
    {
        if ($this->getTags()->contains($tag)) {
            $this->collTags->remove($this->collTags->search($tag));
            if (null === $this->tagsScheduledForDeletion) {
                $this->tagsScheduledForDeletion = clone $this->collTags;
                $this->tagsScheduledForDeletion->clear();
            }
            $this->tagsScheduledForDeletion[]= $tag;
        }
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->author_id = null;
        $this->content_type_id = null;
        $this->date = null;
        $this->access_rights = null;
        $this->validated = null;
        $this->title = null;
        $this->text = null;
        $this->text_isLoaded = false;
        $this->cursus_id = null;
        $this->course_id = null;
        $this->year = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collContentsFiless) {
                foreach ($this->collContentsFiless as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collComments) {
                foreach ($this->collComments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContentsTagss) {
                foreach ($this->collContentsTagss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collReports) {
                foreach ($this->collReports as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFiles) {
                foreach ($this->collFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTags) {
                foreach ($this->collTags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collContentsFiless instanceof PropelCollection) {
            $this->collContentsFiless->clearIterator();
        }
        $this->collContentsFiless = null;
        if ($this->collComments instanceof PropelCollection) {
            $this->collComments->clearIterator();
        }
        $this->collComments = null;
        if ($this->collContentsTagss instanceof PropelCollection) {
            $this->collContentsTagss->clearIterator();
        }
        $this->collContentsTagss = null;
        if ($this->collReports instanceof PropelCollection) {
            $this->collReports->clearIterator();
        }
        $this->collReports = null;
        if ($this->collFiles instanceof PropelCollection) {
            $this->collFiles->clearIterator();
        }
        $this->collFiles = null;
        if ($this->collTags instanceof PropelCollection) {
            $this->collTags->clearIterator();
        }
        $this->collTags = null;
        $this->aAuthor = null;
        $this->aCursus = null;
        $this->aCourse = null;
        $this->aContentType = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ContentPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
