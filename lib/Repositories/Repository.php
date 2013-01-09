<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author dev
 */
interface ObjectRepository {
    public function find($id);
    public function findAll();
    public function persist(Managable $subject);
}
