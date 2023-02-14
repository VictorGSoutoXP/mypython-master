$(function() {

  $.extend($.tablesorter.themes.bootstrap, {
    table      : 'table table-bordered',
    header     : 'bootstrap-header', // give the header a gradient background
    footerRow  : '',
    footerCells: '',
    icons      : '', // add "icon-white" to make them white; this icon class is added to the <i> in the header
    sortNone   : 'bootstrap-icon-unsorted',
    sortAsc    : 'icon-chevron-up',
    sortDesc   : 'icon-chevron-down',
    active     : '', // applied when column is sorted
    hover      : '', // use custom css here - bootstrap class may not override it
    filterRow  : '', // filter row class
    even       : '', // odd row zebra striping
    odd        : ''  // even row zebra striping
  });
  
  $.tablesorter.addParser({
	  id: 'status',
	  is: function(s, table, cell) {
	    return false;
	  },
	  format: function(s, table, cell, cellIndex) {
	    var $cell = $(cell);
	    var data = $cell.data('create-date');
	      if(s == "Aguardando Laudo"){
	          return data + " ";
	      }
	      
	    return s;
	  },
	  type: 'text'
	});

  var t, start;

  var table = $("table.table-list").tablesorter({
    theme : "bootstrap",

    widthFixed: true,

    headerTemplate : '{content} {icon}',

    widgets : [ "uitheme", "filter", "zebra" ],

    widgetOptions : {
      zebra : ["even", "odd"],

      // reset filters button
      filter_reset : ".reset",
      filter_columnFilters: false

    }
  })
  .bind('filterStart filterEnd', function(e, filter){
	    if (e.type === 'filterStart') {
	      start = e.timeStamp;
	      t = 'Filter Started: [' + filter + ']';
	    } else {
	      t = 'Filter Ended after ' + ( (e.timeStamp - start)/1000 ).toFixed(2) + ' seconds';
	    }
	    _log(t);
	  })
  .tablesorterPager({

    // target the pager markup - see the HTML block below
    container: $(".pagination"),
    wrap: $(".tableContainer"),
	cssNumPageContainer: $(".pages-container"),
	cssNumPage: ".page-number",

    cssGoto  : ".pagenum",
    removeRows: false,
    output: '{startRow} - {endRow} / {filteredRows} ({totalRows})'

  });
  
	$(".search-table-list").on("keyup",function(e){
		var str = $(this).val();
		var columns = [];
		columns[1] = str;
		_log([columns])
		table.trigger('search', [columns]);
	});

});