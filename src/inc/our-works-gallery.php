<div class="gallery">
  <div class="container">
    <ul class="gallery__filter">

<?php

$categories = array(

  'all' => array(
    'slug' => 'all',
    'name' => 'Все работы'
  ),
  'septa' => array(
    'slug' => 'septa',
    'name' => 'Перегородки'
  ),
  'kitchens' => array(
  'slug' => 'kitchens',
  'name' => 'Кухонные фартуки'
  ),
  'showers' => array(
  'slug' => 'showers',
  'name' => 'Душевые кабины'
  ),
  // 'stained' => array(
  //   'slug' => 'stained',
  //   'name' => 'Витражи'
  // ),
  'doors' => array(
    'slug' => 'doors',
    'name' => 'Двери'
  ),
  'fences' => array(
    'slug' => 'fences',
    'name' => 'Ограждения'
  ),
  'furniture' => array(
    'slug' => 'furniture',
    'name' => 'Мебель'
  ),
  'panel' => array(
    'slug' => 'panel',
    'name' => 'Панно'
  ),
  'mirrors' => array(
    'slug' => 'mirrors',
    'name' => 'Зеркала'
  ),
  'wall-panels' => array(
    'slug' => 'wall-panels',
    'name' => 'Стеновые панели'
  ),
);

foreach ($categories as $category) {
  $prefixedSlug = ($category["slug"] === "all") ? $category["slug"] : (".".$category["slug"]);
	 echo '<li class="filter gallery__filter__btn" data-filter="'. $prefixedSlug .'"><span class="gallery__filter__name">'. $category["name"] .'</span></li>';
}

?>

    </ul>
  </div>
  <div class="gallery__pager">
    <div class="container">
      <div class="pager-list gallery__pager-list">
      	<!-- Pagination buttons will be generated here -->
      </div>
      <!-- <button class="btn btn--yellow btn--show-more gallery__show-more btn--show-more--expanded">Показать все</button> -->
    </div>
  </div>
  <div class="gallery__container" style="height: 0;">

  </div>

</div>
