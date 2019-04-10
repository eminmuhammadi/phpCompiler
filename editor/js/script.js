
	/**
	*   Display workspace
	*/	
	$("#loading").css('display','none');
	$('main').css('display','block');

	// Toggle Panel
	$("#build").toggle();

	/**
	*   Shortcut Library
	*/
	shortcut={
		all_shortcuts:{},
		add:function(l,p,i){
			var e={type:"keydown",propagate:!1,disable_in_input:!1,target:document,keycode:!1};if(i)for(var t in e)void 0===i[t]&&(i[t]=e[t]);else i=e;var a=i.target;"string"==typeof i.target&&(a=document.getElementById(i.target));l=l.toLowerCase();var r=function(e){var t;if((e=e||window.event,i.disable_in_input)&&(e.target?t=e.target:e.srcElement&&(t=e.srcElement),3==t.nodeType&&(t=t.parentNode),"INPUT"==t.tagName||"TEXTAREA"==t.tagName))return;e.keyCode?code=e.keyCode:e.which&&(code=e.which);var a=String.fromCharCode(code).toLowerCase();188==code&&(a=","),190==code&&(a=".");var r=l.split("+"),n=0,s={"`":"~",1:"!",2:"@",3:"#",4:"$",5:"%",6:"^",7:"&",8:"*",9:"(",0:")","-":"_","=":"+",";":":","'":'"',",":"<",".":">","/":"?","\\":"|"},o={esc:27,escape:27,tab:9,space:32,return:13,enter:13,backspace:8,scrolllock:145,scroll_lock:145,scroll:145,capslock:20,caps_lock:20,caps:20,numlock:144,num_lock:144,num:144,pause:19,break:19,insert:45,home:36,delete:46,end:35,pageup:33,page_up:33,pu:33,pagedown:34,page_down:34,pd:34,left:37,up:38,right:39,down:40,f1:112,f2:113,f3:114,f4:115,f5:116,f6:117,f7:118,f8:119,f9:120,f10:121,f11:122,f12:123},d={shift:{wanted:!1,pressed:!1},ctrl:{wanted:!1,pressed:!1},alt:{wanted:!1,pressed:!1},meta:{wanted:!1,pressed:!1}};e.ctrlKey&&(d.ctrl.pressed=!0),e.shiftKey&&(d.shift.pressed=!0),e.altKey&&(d.alt.pressed=!0),e.metaKey&&(d.meta.pressed=!0);for(var c=0;k=r[c],c<r.length;c++)"ctrl"==k||"control"==k?(n++,d.ctrl.wanted=!0):"shift"==k?(n++,d.shift.wanted=!0):"alt"==k?(n++,d.alt.wanted=!0):"meta"==k?(n++,d.meta.wanted=!0):1<k.length?o[k]==code&&n++:i.keycode?i.keycode==code&&n++:a==k?n++:s[a]&&e.shiftKey&&(a=s[a])==k&&n++;if(n==r.length&&d.ctrl.pressed==d.ctrl.wanted&&d.shift.pressed==d.shift.wanted&&d.alt.pressed==d.alt.wanted&&d.meta.pressed==d.meta.wanted&&(p(e),!i.propagate))return e.cancelBubble=!0,e.returnValue=!1,e.stopPropagation&&(e.stopPropagation(),e.preventDefault()),!1};this.all_shortcuts[l]={callback:r,target:a,event:i.type},a.addEventListener?a.addEventListener(i.type,r,!1):a.attachEvent?a.attachEvent("on"+i.type,r):a["on"+i.type]=r
		},
		remove:function(e){
			e=e.toLowerCase();
			var t=this.all_shortcuts[e];
			if(delete this.all_shortcuts[e],t){
				var a=t.event,r=t.target,n=t.callback;r.detachEvent?r.detachEvent("on"+a,n):r.removeEventListener?r.removeEventListener(a,n,!1):r["on"+a]=!1}
		}
	};

	/**
	*  Scroll Down
	*/	
	function showEnd(e){
    			if(e.length)
      				 e.scrollTop(e[0].scrollHeight - e.height());
	}

	/**
	*  Code Mirror Installing
	*/

	CodeMirror.modeURL = "/editor/assets/codemirror/mode/%N/%N.js";
	var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
  		
  		lineNumbers: true,
  		theme: "eclipse",
  		autoCloseBrackets: true,
  		viewportMargin: Infinity,

  		extraKeys: {
  			"Ctrl-F": "findPersistent",
        	"F11": function(cm) {
          		cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        	},
        	"Esc": function(cm) {
          		if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        	}        	  			
  		}

	});


	/**
	*  Code Mirror Editor Size
	*/		
	editor.setSize(null,'100%');
	var modeInput = document.getElementById("mode");
		CodeMirror.on(modeInput, "keypress", function(e) {
  		if (e.keyCode == 13) change();
	});



	/**
	*  Check Document Ready Statement
	*/	

    $(document).ready(function(){
 

	/**
	*  Change mode dynamically
	*/
	$( "#change" ).click(function() {


  		var val = modeInput.value, m, mode, spec;
  		
  		if (m = /.+\.([^.]+)$/.exec(val)) {
    		var info = CodeMirror.findModeByExtension(m[1]);
    			if (info) {
      				mode = info.mode;
      				spec = info.mime;
    			}
  		} 

  		else if (/\//.test(val)) {
    		var info = CodeMirror.findModeByMIME(val);
    			if (info) {
      				mode = info.mode;
      				spec = val;
    			}
  		} 

  		else {
    				mode = spec = val;
  		}
  		
  		if (mode) {
    		editor.setOption("mode", spec);
    		CodeMirror.autoLoadMode(editor, mode);
   			$("#output").append('$root '+spec+' > \n');
   			showEnd($('#output'));
  		} 
  		else {
    		alert("Please change file extension to correct one. " + val + " is invalid.");    		
  		}

	});

    /**
	*  Panel Toggle
	*/		
	$( "#backpanel" ).click(function() {
  		$("#build").toggle();
	});

    /**
	*  Clear Output
	*/	
	$( "#clear" ).click(function() {
  		$("#output").html('$root clear > Cleared\n');
	});

	/**
	*  Substr for Extension
	*/	
	function extension(e,v){
		return e.substr(e.length - v);
	}

	/**
	*  Connect with API
	*/	
	function apiLang(fn){

			if(extension(fn,'4')=='.cpp'){
				return '/runCpp.php';
			}
			else{
				if(extension(fn,'5')=='.java'){	
					return '/runJavac.php';
				}
				else{
					if(extension(fn,'3')=='.py'){
						return '/runPython.php';
					}
					else{
						if(extension(fn,'7')=='.11.cpp'){
							return '/runC11.php'
						}
						else {
							if(extension(fn,'2')=='.c'){
								return '/runC.php';
							}
							else {
    							alert("Please change file extension to correct one. " + fn + " is invalid.");
    							return false;
							}
						}						
					}
				}
			}

	}
	/**
	*   Block for Multi result
	*/
	function feature(){

		var cm = $('.CodeMirror')[0].CodeMirror;
		$(cm.getWrapperElement()).hide();

		$("#run").attr("disabled", true);
		$("#change").attr("disabled", true);
		$("#code-load").css("display","block");
		$("#input").attr("disabled", true);

		$("#run").html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>`);
	    setTimeout(function() { 

	    	$("#run").html(`<i class="fas fa-play"></i>`);
			$("#run").attr("disabled", false);
			$("#change").attr("disabled", false);	
			$("#code-load").css("display","none");
			$("#input").attr("disabled", false);
			$(cm.getWrapperElement()).show();

    	},3000);

	}

	/**
	*  Run Code
	*/	

	function run(){

			var code   = editor.getValue();
			var input  = $("#input").val();    	
	  		var fnMode = $("#mode").val();

    		$.post(apiLang(fnMode),
    		{
      			code: code,
      			input: input
    		},
    		
    		// Show Data
    		function(data){

    			$("#output").append(data.result.output+'\n');

				if(data.result.error != null) {
					$("#error").append(`
						<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
  						<strong>Error :</strong> `+data.result.error+`
  							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    							<span aria-hidden="true">&times;</span>
  							</button></div>`);
					setTimeout(function() { $(".alert").alert('close');$("#build").toggle();},4000);
				}

			});
	}

	function showBuild(){
		if ($("#build").is(":hidden")) { 
	   		$("#build").toggle() ; 
	  	}	
	}

	/**
	*  Run Function
	*/ 
  	$("#run").click(function(){
  		feature();
  		run();
	    setTimeout(function() {  showBuild(); showEnd($('#output'));},1000);  		
  	});


  	// Added Some Keys for running Like IDE
  			
	shortcut.add("F12", function() {
  		feature();		
  		run();
	    setTimeout(function() {  showBuild(); showEnd($('#output'));},1000);  			
	});

	shortcut.add("F9", function() {
    	$("#build").toggle();
	});

	shortcut.add("CTRL+S", function() {
    	var code   = editor.getValue();
    	var fn     = $("#mode").val();
    	download(fn, code);
	});


	function download(fn, text) {

  		var val = modeInput.value, m, mode, spec;
  		
  		if (m = /.+\.([^.]+)$/.exec(val)) {
    		var info = CodeMirror.findModeByExtension(m[1]);
    			if (info) { mode = info.mode; spec = info.mime; }} 

  		else if (/\//.test(val)) {
    		var info = CodeMirror.findModeByMIME(val);
    			if (info) { mode = info.mode; spec = val; }} 

  		else { mode = spec = val; }    

    	var element = document.createElement('a');
    	element.setAttribute('href', 'data:'+val+';charset=utf-8,' + encodeURIComponent(text));
    	element.setAttribute('download', fn);

    	element.style.display = 'none';
    	document.body.appendChild(element);

    	element.click();
    	document.body.removeChild(element);

	}

  	$("#download").click(function(){
		var code   = editor.getValue();
    	var fn     = $("#mode").val();
    
    	download(fn, code);
	});



	window.addEventListener("beforeunload", function(event) {
    	event.returnValue = "Do you want to leave?";
	});

  	//end ready
    });	