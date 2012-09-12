<?php

/*
 * Copyright (C) 2009-2011 Internet Neutral Exchange Association Limited.
 * All Rights Reserved.
 *
 * This file is part of IXP Manager.
 *
 * IXP Manager is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation, version v2.0 of the License.
 *
 * IXP Manager is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License v2.0
 * along with IXP Manager.  If not, see:
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */


/**
 * Form: adding / editing switches
 *
 * @author     Barry O'Donovan <barry@opensolutions.ie>
 * @category   INEX
 * @package    INEX_Form
 * @copyright  Copyright (c) 2009 - 2012, Internet Neutral Exchange Association Ltd
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU GPL V2.0
 */
class INEX_Form_Switch extends INEX_Form
{
    public function init()
    {

        $name = $this->createElement( 'text', 'name' );
        $name->addValidator( 'stringLength', false, array( 1, 255 ) )
            ->setAttrib( 'class', 'span3' )
            ->setRequired( true )
            ->setLabel( 'Name' )
            ->addFilter( 'StringTrim' )
            ->addFilter( new OSS_Filter_StripSlashes() );
        $this->addElement( $name );

        $switchtype = $this->createElement( 'select', 'switchtype' );
        $switchtype->setMultiOptions( \Entities\Switcher::$TYPES )
            ->setAttrib( 'class', 'span3 chzn-select' )
            ->setRegisterInArrayValidator( true )
            ->addValidator( 'greaterThan', true, array( 0 ) )
            ->setLabel( 'Type' )
            ->setErrorMessages( array( 'Please set the switch type' ) );
        $this->addElement( $switchtype );

        $this->addElement( INEX_Form_Cabinet::getPopulatedSelect( 'cabinetid' ) );

        $infrastructre = $this->createElement( 'text', 'infrastructure' );
        $infrastructre->setLabel( 'Infrastructure' )
            ->setAttrib( 'class', 'span3' )
            ->addFilter( 'StringTrim' )
            ->addFilter( new OSS_Filter_StripSlashes() );
        $this->addElement( $infrastructre );


        $ipv4addr = $this->createElement( 'text', 'ipv4addr' );
        $ipv4addr->addValidator( 'stringLength', false, array( 1, 255 ) )
            ->setAttrib( 'class', 'span3' )
            ->setRequired( true )
            ->setLabel( 'IPv4 Address' )
            ->addFilter( 'StringTrim' )
            ->addFilter( new OSS_Filter_StripSlashes() );
        $this->addElement( $ipv4addr );

        $ipv6addr = $this->createElement( 'text', 'ipv6addr' );
        $ipv6addr->addValidator( 'stringLength', false, array( 1, 255 ) )
            ->setAttrib( 'class', 'span3' )
            ->setLabel( 'IPv6 Address' )
            ->addFilter( 'StringTrim' )
            ->addFilter( new OSS_Filter_StripSlashes() );
        $this->addElement( $ipv6addr );

        $snmppasswd = $this->createElement( 'text', 'snmppasswd' );
        $snmppasswd->addValidator( 'stringLength', false, array( 1, 255 ) )
            ->setAttrib( 'class', 'span3' )
            ->setLabel( 'SNMP Community' )
            ->addFilter( 'StringTrim' )
            ->addFilter( new OSS_Filter_StripSlashes() );
        $this->addElement( $snmppasswd );

        $this->addElement( INEX_Form_Vendor::getPopulatedSelect( 'vendorid' ) );
        

        $model = $this->createElement( 'text', 'model' );
        $model->addValidator( 'stringLength', false, array( 1, 255 ) )
            ->setLabel( 'Model' )
            ->setAttrib( 'class', 'span3' )
            ->addFilter( 'StringTrim' )
            ->addFilter( new OSS_Filter_StripSlashes() );
        $this->addElement( $model );


        $notes = $this->createElement( 'textarea', 'notes' );
        $notes->setLabel( 'Notes' )
            ->setAttrib( 'class', 'span3' )
            ->setRequired( false )
            ->addFilter( new OSS_Filter_StripSlashes() )
            ->setAttrib( 'cols', 60 )
            ->setAttrib( 'rows', 5 );
        $this->addElement( $notes );
        
        $active = $this->createElement( 'checkbox', 'active' );
        $active->setLabel( 'Active?' )
            ->setCheckedValue( '1' )
            ->setUncheckedValue( '0' )
            ->setValue( '1' );
        $this->addElement( $active );
        

        $this->addElement( self::createSubmitElement( 'submit', _( 'Add' ) ) );
        $this->addElement( $this->createCancelElement() );
    }

}
