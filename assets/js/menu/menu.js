$(document).ready(function () {
  const url = $('#current_sid_token').val();
  const currentPath = $('#' + url)
  currentPath.addClass('active')
  //let parent = null
  // do {
  let parent = currentPath.closest('.has-treeview')
  parent.addClass('menu-open')
  $(parent.find('.nav-link')[0]).addClass('active')

  let parent2 = parent.parent('.has-treeview')
  console.log(parent2.text())
  parent.addClass('menu-open')
  $(parent.find('.nav-link')[0]).addClass('active')
  // }while(parent !== null)
});