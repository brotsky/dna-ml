<?php
class DataRow {
  public $data = false;
  public $region = false;
  public $position = false;
  public $gene = false;

  public $mutations = false;
  public $differences = false;

  function __construct($cells) {
    $data = false;
    foreach($cells as $key => $cell) {
      if($key > 3) {
        $data[] = $cell;
      }
    }
    $this->data = $data;
    $this->region = $cells[0];
    $this->position = $cells[1];
    $this->gene = $cells[2];
    $this->max = $this->maxPercentage();
    $this->min = $this->minPercentage();
    if($this->max > 0.02) {
      $this->mutations = true;
    }
    if($this->max - $this->min > JUNK_MUTATION_LIMIT) {
      $this->differences = true;
    }
  }

  function maxPercentage() {
    return max($this->data);
  }

  function minPercentage() {
    return min($this->data);
  }
}