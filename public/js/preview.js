(function( $, window, undefined ) {
  $.danidemo = $.extend( {}, {
    
    addLog: function(id, status, str){
      var d = new Date();
      var li = $('<li />', {'class': '' + status});
       
      var message = '[' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds() + '] ';
      
      message += str;
     
      li.html(message);
      
      $(id).prepend(li);
    },
    
    addFile: function(id, i, file){
		var template = '<div id="file' + i + '" class="file">' +
		                   '<img src="" class="image-preview" />' + 
		                   '<a href="#">X</a>'+ file.name +
		                   '<span class="file-size"> (' + $.danidemo.humanizeSize(file.size) + ')</span><br />'+
		                   '<span class="sr-only">Transfert 0%</span>'+
		                   '<br><span class="file-status">En attente de téléchargement...</span>'+
		                   '<div class="clear"></div>'+
		               '</div>';
		               
		var i = $(id).attr('file-counter');
		if (!i){
			$(id).empty();
			
			i = 0;
		}
		
		i++;
		
		$(id).attr('file-counter', i);
		
		$(id).prepend(template);
	},
	
	updateFileStatus: function(i, status, message){
		$('#file' + i).find('span.file-status').html(message).addClass('file-status-' + status);
	},
	
	updateFileProgress: function(i, percent){
		$('#file' + i).find('span.sr-only').html('Transfert : ' + percent);
	},
	
	humanizeSize: function(size) {
      var i = Math.floor( Math.log(size) / Math.log(1024) );
      return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
    }

  }, $.danidemo);
})(jQuery, this);

