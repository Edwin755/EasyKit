(function($){
	
	$.fn.dropfile = function(oo){

	var o = {
		message : "Déposé vos fichier ici",
		script : 'upload.php',
		clone : true
	}
					
		if(oo) $.extend(o,oo);
		var replace = false;
		this.each(function(){
			$('<span>').append(o.message).addClass('message').appendTo(this);
			$('<span>').addClass('progress').appendTo(this);
			$('<span>').addClass('progress-number').appendTo(this);
			$(this).bind({
				dragenter : function(e){
					e.preventDefault();
				},
				dragover : function(e){
					e.preventDefault();
					$(this).addClass('hover');
				},
				dragleave : function(e){
					e.preventDefault();
					$(this).removeClass('hover');
				}
			});
			this.addEventListener('drop',function(e){
				e.preventDefault();
				var files = e.dataTransfer.files;
				if($(this).data('value')){
					replace = true;
				}
				upload(files,$(this),0);
			}, false);
		});
		
		function upload(files,area,index){
			var file = files[index];
			if(index > 0 && o.clone){
				area = area.clone().html('').insertAfter(area).dropfile(o);
				area.data('value',null);
			}
			var xhr = new XMLHttpRequest();
			var progress = area.find('.progress');
			var progressnumber = area.find('.progress-number');
			var message = area.find('.message');
			//Event
			
			xhr.addEventListener('load',function(e){				
				var json = jQuery.parseJSON(e.target.responseText);
				area.removeClass('hover');
				progress.css({height:0});
				
				if(index<files.length-1){
					upload(files,area,index+1);
				}
				
				if(o.clone && !replace && index == files.length - 1){
					area.clone().html('').insertAfter(area).dropfile(o);
				}
				
				progressnumber.html('');
				
				if(json.error){
					alert(json.error);
					return false;
				}else{
					area.prepend(json.content);
				}
			});
			
			xhr.upload.addEventListener('progress',function(e){
				if(e.lengthComputable){
					var perc = Math.round((e.loaded/e.total)*100)+'%';
					progress.css({height:perc});
					progressnumber.html(perc);
					message.html('');					
				}
			},false)
			
			xhr.open('post',o.script,true);
			xhr.setRequestHeader('content-type','multipart/form-data');
			xhr.setRequestHeader('x-file-type',file.type);
			xhr.setRequestHeader('x-file-size',file.size);
			xhr.setRequestHeader('x-file-name',file.name);
			
			for(var i in area.data()){
				if(typeof area.data(i) !== 'object'){
					xhr.setRequestHeader('x-param-'+i,area.data(i));
				}
			} 
			
			xhr.send(file);
		}
		
		return this;
	}
	
})(jQuery);