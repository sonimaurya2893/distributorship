function getChartColorsArray(e){if(null!==document.getElementById(e)){var t=document.getElementById(e).getAttribute("data-colors");if(t)return(t=JSON.parse(t)).map(function(e){var t=e.replace(" ","");if(-1===t.indexOf(",")){var o=getComputedStyle(document.documentElement).getPropertyValue(t);return o||t}e=e.split(",");return 2!=e.length?t:"rgba("+getComputedStyle(document.documentElement).getPropertyValue(e[0])+","+e[1]+")"});console.warn("data-colors Attribute not found on:",e)}}function ChartColorChange(t,o){document.querySelectorAll(".theme-color").forEach(function(e){e.addEventListener("click",function(e){setTimeout(function(){var e=getChartColorsArray(o);t.options&&(t.options.colors?t.options.colors=e:t.options.lineColors?t.options.lineColors=e:t.options.barColors&&(t.options.barColors=e),t.redraw())},0)})})}!function(e){"use strict";function t(){}t.prototype.createAreaChart=function(e,t,o,r,a,n,i,l){ChartColorChange(Morris.Area({element:e,pointSize:0,lineWidth:0,data:r,xkey:a,ykeys:n,labels:i,resize:!0,gridLineColor:"#eeee",hideHover:"auto",lineColors:l,fillOpacity:.7,behaveLikeLine:!0}),"morris-area-example")},t.prototype.createDonutChart=function(e,t,o){ChartColorChange(Morris.Donut({element:e,data:t,resize:!0,colors:o}),"morris-donut-example")},e(".peity-pie").each(function(){e(this).peity("pie",e(this).data())}),e(".peity-donut").each(function(){e(this).peity("donut",e(this).data())}),t.prototype.init=function(){var e=getChartColorsArray("morris-area-example");e&&this.createAreaChart("morris-area-example",0,0,[{y:"2011",a:0,b:0,c:0},{y:"2012",a:150,b:45,c:15},{y:"2013",a:60,b:150,c:195},{y:"2014",a:180,b:36,c:21},{y:"2015",a:90,b:60,c:360},{y:"2016",a:75,b:240,c:120},{y:"2017",a:30,b:30,c:30}],"y",["a","b","c"],["Series A","Series B","Series C"],e);e=getChartColorsArray("morris-donut-example");e&&this.createDonutChart("morris-donut-example",[{label:"Download Sales",value:12},{label:"In-Store Sales",value:30},{label:"Mail-Order Sales",value:20}],e)},e.Dashboard=new t,e.Dashboard.Constructor=t}(window.jQuery),function(){"use strict";window.jQuery.Dashboard.init()}();