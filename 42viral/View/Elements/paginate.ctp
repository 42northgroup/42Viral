<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if($this->Paginator->counter(array('format'=>"%pages%")) > 1){
    echo $this->Html->div(
        'paginator',
        (
        !$this->Paginator->hasPrev()?
            $this->Html->tag('span', '<<', array('class' => 'disabled-page-link'))
        :
            $this->Paginator->first(
                '<<',
                array(
                    'class' => 'pagination-link'
                ),
                null,
                array(
                    'class' => 'disabled-page-link'
                )
            )
        ).
        $this->Paginator->prev(
            '<',
            array(
                'class' => 'pagination-link'
            ),
            null,
            array(
                'class' => 'disabled-page-link'
            )
        ).
        $this->Paginator->numbers(
            array('separator'=>'',
                'class'=>'pagination-link'
            )
        ).
        $this->Paginator->next(
            '>',
            array(
                'class' => 'pagination-link'
            ),
            null,
            array(
                'class' => 'disabled-page-link'
            )
        ).
        (
        !$this->Paginator->hasNext()?
            $this->Html->tag('span', ">> ({$this->Paginator->counter(array('format'=>"%pages%"))})",
                    array('class' => 'disabled-page-link'))
        :
            $this->Paginator->last(
                ">>  ({$this->Paginator->counter(array('format'=>"%pages%"))})",
                array(
                    'class' => 'pagination-link'
                ),
                null,
                array(
                    'class' => 'disabled-page-link'
                )
            )
        ),
        array('style'=>'margin-top:12px;')
    );
}else{
    return null;
}
