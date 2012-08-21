<?php



/**
 * Skeleton subclass for representing a row from the 'cursus' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.ip7website
 */
class Cursus extends BaseCursus {

    public function getShortName() {
        return strtoupper(parent::getShortName());
    }

} // Cursus
