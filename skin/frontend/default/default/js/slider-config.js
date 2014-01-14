// JavaScript Document
var $q = jQuery.noConflict();
	jQuery(function( $q ){
		//borrowed from jQuery easing plugin
		//http://gsgd.co.uk/sandbox/jquery.easing.php
		$q.easing.backout = function(x, t, b, c, d){
			var s=1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		};
		
		$q('#screen').scrollShow({
			view:'#view',
			content:'#images',
			easing:'backout',
			wrappers:'link,crop',
			navigators:'a[id]',
			navigationMode:'s',
			circular:false,
			start:0
		});
	 });
	
	jQuery(function( $q ){
		//borrowed from jQuery easing plugin
		//http://gsgd.co.uk/sandbox/jquery.easing.php
		$q.easing.backout = function(x, t, b, c, d){
			var s=1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		};
		
		$q('#screen2').scrollShow({
			view:'#view2',
			content:'#images2',
			easing:'backout',
			wrappers:'link,crop',
			navigators:'a[id]',
			navigationMode:'s',
			circular:false,
			start:0
		});
	 });
	 
	 jQuery(function( $q ){
		//borrowed from jQuery easing plugin
		//http://gsgd.co.uk/sandbox/jquery.easing.php
		$q.easing.backout = function(x, t, b, c, d){
			var s=1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		};
		
		$q('#screen3').scrollShow({
			view:'#view3',
			content:'#images3',
			easing:'backout',
			wrappers:'link,crop',
			navigators:'a[id]',
			navigationMode:'s',
			circular:false,
			start:0
		});
	 });