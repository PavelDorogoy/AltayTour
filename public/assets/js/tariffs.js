
// select box
$('.type-select-dropdown').click(function(){
  $(this).toggleClass('open');
  $('.type-options', this).toggleClass('open');
});

$('.type-options li').click(function(){
  let selection = $(this).text();
  let dataValue = $(this).attr('data-value');
  $('.type-selected-option span').text(selection);
  $('.type-select-dropdown').attr('data-selected-value', dataValue);
});

$('.time-select-dropdown').click(function(){
  $(this).toggleClass('open');
  $('.time-options', this).toggleClass('open');
});

$('.time-options li').click(function(){
  let selection = $(this).text();
  let dataValue = $(this).attr('data-value');
  $('.time-selected-option span').text(selection);
  $('.time-select-dropdown').attr('data-selected-value', dataValue);
});

$('.season-select-dropdown').click(function(){
  $(this).toggleClass('open');
  $('.season-options', this).toggleClass('open');
});

$('.season-options li').click(function(){
  let selection = $(this).text();
  let dataValue = $(this).attr('data-value');
  $('.season-selected-option span').text(selection);
  $('.season-select-dropdown').attr('data-selected-value', dataValue);
});

$('.price-select-dropdown').click(function(){
  $(this).toggleClass('open');
  $('.price-options', this).toggleClass('open');
});

$('.price-options li').click(function(){
  let selection = $(this).text();
  let dataValue = $(this).attr('data-value');
  $('.price-selected-option span').text(selection);
  $('.price-select-dropdown').attr('data-selected-value', dataValue);
});