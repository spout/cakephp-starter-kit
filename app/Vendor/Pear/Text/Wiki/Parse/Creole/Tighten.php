<?php

/**
 *
 * The rule removes all remaining newlines.
 *
 * @category Text
 *
 * @package Text_Wiki
 *
 * @author Paul M. Jones <pmjones@php.net>
 *
 * @license LGPL
 *
 * @version $Id: Tighten.php,v 1.1 2006/10/23 13:11:27 mic Exp $
 *
 */


class Text_Wiki_Parse_Tighten extends Text_Wiki_Parse {


    /**
     *
     * Apply tightening directly to the source text.
     *
     * @access public
     *
     */

    function parse()
    {
        $this->wiki->source = str_replace("\n", '',
            $this->wiki->source);
    }
}
?>