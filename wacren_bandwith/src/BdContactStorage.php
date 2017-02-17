<?php

namespace Drupal\wacren_bandwith;

class BdContactStorage {

static function getDataToChart() {
    $result = db_query('SELECT ROUND(AVG(price),0) AS moyCout,MIN(price) AS minCout,MAX(price) AS maxCout,country FROM {wacren_bandwith}  GROUP BY country ')->fetchAll();
return $result;
  }

static function getDataToChartByCountry($country) {
    $result = db_query('SELECT ROUND(AVG(price),0) AS moyCout,MIN(price) AS minCout,MAX(price) AS maxCout,country,dyear FROM {wacren_bandwith}  GROUP BY country,dyear HAVING country = :country ',array(':country' => $country))->fetchAll();
 if ($result) {
      return $result;
    }
    else {
      return FALSE;
    }
  }

  static function getAll() {
    $result = db_query('SELECT * FROM {wacren_bandwith}')->fetchAllAssoc('id');
    return $result;
  }

  static function exists($id) {
    return (bool) $this->get($id);
  }

  static function get($id) {
    $result = db_query('SELECT * FROM {wacren_bandwith} WHERE id = :id', array(':id' => $id))->fetchAllAssoc('id');
    if ($result) {
      return $result[$id];
    }
    else {
      return FALSE;
    }
  }


  static function add($firstname, $lastname, $institution, $pays, $month, $dyear, $price, $bandwith, $infos) {
    db_insert('wacren_bandwith')->fields(array(
      'firstname' => $firstname,
      'lastname' => $lastname,
      'institution' => $institution,
      'country' => $pays,
      'month' => $month,
      'dyear' => $dyear,
      'price' => $price,
      'bandwith' => $bandwith,
      'informations' => $infos,
    ))->execute();
  }

  static function edit($id, $firstname, $lastname, $institution, $pays, $month, $dyear, $price, $bandwith, $infos) {
    db_update('wacren_bandwith')->fields(array(
        'firstname' => $firstname,
      'lastname' => $lastname,
      'institution' => $institution,
      'country' => $pays,
      'year' => $year,
      'price' => $price,
      'bandwith' => $bandwith,
      'informations' => $infos,
    ))
    ->condition('id', $id)
    ->execute();
  }
  
  static function delete($id) {
    db_delete('wacren_bandwith')->condition('id', $id)->execute();
  }
}
