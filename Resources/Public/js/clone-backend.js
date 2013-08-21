jQuery(document).ready(function(){
	jQuery('.add-more-related-link').click(function() {
		cloneAddLink();
	});
	jQuery('.add-more-media').click(function() {
		cloneAddMedia();
	});
	jQuery('.add-more-files').click(function() {
		cloneAddFiles();
	});
	if(!jQuery('#categories option').val()) {
		jQuery('#categories option').attr('disabled', true);
	}
	if(!jQuery('#tags option').val()) {
		jQuery('#tags option').attr('disabled', true);
	}
	if(!jQuery('#relatedNews option').val()) {
		jQuery('#relatedNews option').attr('disabled', true);
	}
	jQuery('.asset-toggle').click(function() {
		hideShowTest(this);
	});

	/***Ajax to delete Asset****/
	   jQuery('.remove-media').click(function(event) {
		       event.preventDefault();
		       var itemDeleteMessage = confirm(deleteMessage);
		       if (itemDeleteMessage == true) {
			var assetId = jQuery('.asset-id').val();
			var newsId = jQuery('.news-id').val();
			var eleobj = this;
			jQuery.ajax({
				beforeSend: function() {
					jQuery(eleobj).prev('.loader').show();
				},
				complete: function(){
					jQuery('.loader').hide();
				},
				url:removeAsset+'?moduleArguments[%40package]=lelesys.plugin.news&moduleArguments[%40controller]=news&moduleArguments[%40action]=removeasset&moduleArguments[assetId]='+assetId+'&moduleArguments[newsId]='+newsId,
				async:false,
				dataType: 'json',
				success: function(data) {
					jQuery(eleobj).parent().parent().remove();
				}
			});
		       }
		else {
			return false;
		}
	   });

	/***Ajax to delete Tag****/
	   jQuery('.remove-tag').click(function(event) {
		       event.preventDefault();
		       var itemDeleteMessage = confirm(deleteMessage);
		       if (itemDeleteMessage == true) {
			var tagId = jQuery('.tag-id').val();
			var newsId = jQuery('.news-id').val();
			var eleobj = this;
			jQuery.ajax({
				beforeSend: function() {
					jQuery(eleobj).parent('.badge').prev('.loader').show();
				},
				complete: function(){
					jQuery('.loader').hide();
				},
				url:removeTag+'?moduleArguments[%40package]=lelesys.plugin.news&moduleArguments[%40controller]=news&moduleArguments[%40action]=removetag&moduleArguments[tagId]='+tagId+'&moduleArguments[newsId]='+newsId,
				async:false,
				dataType: 'json',
				success: function(data) {
					jQuery(eleobj).parent().remove();
				}
			});
		       }
		else {
			return false;
		}
	   });



	/***Ajax to delete file****/
	jQuery('.delete-file').click(function(event) {
		event.preventDefault();
		       var itemDeleteMessage = confirm(deleteMessage);
		       if (itemDeleteMessage == true) {
			var fileId = jQuery('.file-id').val();
			var newsId = jQuery('.news-id').val();
			var eleobj = this;
			jQuery.ajax({
				beforeSend: function() {
					jQuery(eleobj).prev('.loader').show();
				},
				complete: function(){
					jQuery('.loader').hide();
				},
				url: removeFile+'?moduleArguments[%40package]=lelesys.plugin.news&moduleArguments[%40controller]=news&moduleArguments[%40action]=removeRelatedFile&moduleArguments[fileId]='+fileId+'&moduleArguments[newsId]='+newsId,
				async:false,
				dataType: 'json',
				success: function(data) {
					jQuery(eleobj).parent().parent().remove();
				}
			});
		 }
		else {
			return false;
		}
	});

	/***Ajax to delete related link****/
	jQuery('.remove-related-link').click(function(event) {
		event.preventDefault();
		       var itemDeleteMessage = confirm(deleteMessage);
		       if (itemDeleteMessage == true) {
			var linkId = jQuery('.link-id').val();
			var newsId = jQuery('.news-id').val();
			var eleobj = this;
			jQuery.ajax({
				beforeSend: function() {
					jQuery(eleobj).prev('.loader').show();
				},
				complete: function(){
					jQuery('.loader').hide();
				},
				url: removeRelatedLink+'?moduleArguments[%40package]=lelesys.plugin.news&moduleArguments[%40controller]=news&moduleArguments[%40action]=removeRelatedLink&moduleArguments[linkId]='+linkId+'&moduleArguments[newsId]='+newsId,
				async:false,
				dataType: 'json',
				success: function(data) {
					jQuery(eleobj).parent().parent().remove();
				}
			});
		}
		else {
			return false;
		}
	});
});

function hideShowTest(eleobj) {
	if(jQuery(eleobj).hasClass('hide-asset')) {
		jQuery(eleobj).children('i').addClass('icon-eye-open').removeClass('icon-eye-close');
		jQuery(eleobj).prev('input[type="hidden"]').val(1);
		jQuery('.tooltip').remove();
		jQuery(eleobj).attr('data-original-title', 'Show').addClass('show-asset').removeClass('hide-asset');
	} else {
		jQuery(eleobj).children('i').addClass('icon-eye-close').removeClass('icon-eye-open');
		jQuery(eleobj).prev('input[type="hidden"]').val(0);
		jQuery('.tooltip').remove();
		jQuery(eleobj).attr('data-original-title', 'Hide').addClass('hide-asset').removeClass('show-asset');
	}
};

function cloneAddLink() {
	var div = jQuery('.add-more-related-link').prev('.accordion-group').clone();
	div.css('display', 'block');
	div.find('.link-id').remove();
	div.find('input[type="text"],textarea').val('');
	var collapseName = div.find('.accordion-body').attr('id');
	var newId = parseInt(collapseName.split('-')[2])+1;
	div.find('.accordion-body').attr('id','collapse-link-'+newId);
	div.find('.accordion-toggle').attr('href','#collapse-link-'+newId);
	div.find('.accordion-toggle').text('Related Link #'+newId);
	div.find('.show-hide-value').val(0).attr('name','moduleArguments[relatedLink]['+newId+'][hidden]');
	div.find('.asset-toggle').attr('data-original-title', 'Hide').addClass('hide-asset link-clone-toggle').removeClass('show-asset');
	div.find('.asset-toggle').children('i').addClass('icon-eye-close').removeClass('icon-eye-open');
	var a = newId - 1;
	div.find('#relatedLinks-'+a).attr({
		'name': 'moduleArguments[relatedLink]['+newId+'][relatedUri]',
		'id': 'relatedLinks-'+newId
	}).parent().prev('label').attr('for','relatedLinks-'+newId);
	div.find('#relatedLinks-title-'+a).attr({
		'name': 'moduleArguments[relatedLink]['+newId+'][relatedUriTitle]',
		'id': 'relatedLinks-title-'+newId
	}).parent().prev('label').attr('for','relatedLinks-title-'+newId);
	div.find('#relatedLinks-description-'+a).attr({
		'name': 'moduleArguments[relatedLink]['+newId+'][relatedUriDescription]',
		'id': 'relatedLinks-description-'+newId
	}).parent().prev('label').attr('for','relatedLinks-description-'+newId);
	div.find('#collapse-link-'+newId).removeClass('in').removeAttr("style");
	div.find('.remove-file').remove();
	div.find('.accordion-heading').append('<a class="pull-right remove-file tooltip-demo" rel="tooltip" title="Delete" onclick="deleteClone(this)"><i class="icon-trash"></i></a>');
	jQuery('.add-more-related-link').before(div);
	jQuery('.link-clone-toggle').click(function() {
		jQuery('.tooltip-demo').tooltip();
		hideShowTest(this);
	});
};

function cloneAddFiles() {
	var div = jQuery('.add-more-files').prev('.accordion-group').clone();
	div.css('display', 'block');
	div.find('input[type="file"]').css('display', 'block');
	div.find('.file-id').remove();
	div.find('input[type="text"],input[type="file"],textarea').val('');
	var collapseName = div.find('.accordion-body').attr('id');
	var newId = parseInt(collapseName.split('-')[2])+1;
	div.find('.accordion-body').attr('id','collapse-file-'+newId);
	div.find('.accordion-toggle').attr('href','#collapse-file-'+newId);
	div.find('.accordion-toggle').text('Related Files #'+newId);
	div.find('.show-hide-value').val(0).attr('name','moduleArguments[file]['+newId+'][hidden]');
	div.find('.asset-toggle').attr('data-original-title', 'Hide').addClass('hide-asset file-clone-toggle').removeClass('show-asset');
	div.find('.asset-toggle').children('i').addClass('icon-eye-close').removeClass('icon-eye-open');
	var a = newId - 1;
	div.find('#file-originalResource-'+a).attr({
		'name': 'moduleArguments[file]['+newId+'][originalFileResource]',
		'id': 'file-originalResource-'+newId
	}).parent().prev('label').attr('for','file-originalResource-'+newId);
	div.find('#file-title-'+a).attr({
		'name': 'moduleArguments[file]['+newId+'][title]',
		'id': 'file-title-'+newId
	}).parent().prev('label').attr('for','file-title-'+newId);
	div.find('#file-description-'+a).attr({
		'name': 'moduleArguments[file]['+newId+'][description]',
		'id': 'file-description-'+newId
	}).parent().prev('label').attr('for','file-description-'+newId);
	div.find('#file-originalResource-'+newId).next('img').remove();
	div.find('#collapse-file-'+newId).removeClass('in').removeAttr("style");
	div.find('.remove-file').remove();
	div.find('.accordion-heading').append('<a class="pull-right remove-file tooltip-demo" rel="tooltip" title="Delete" onclick="deleteClone(this)"><i class="icon-trash"></i></a>');
	jQuery('.add-more-files').before(div);
	jQuery('.tooltip-demo').tooltip();
	jQuery('.file-clone-toggle').click(function() {
		hideShowTest(this);
	});
};

function cloneAddMedia() {
	var div = jQuery('.add-more-media').prev('.accordion-group').clone();
	div.css('display', 'block');
	div.find('input[type="file"]').css('display', 'block');
	div.find('.asset-id').remove();
	div.find('input[type="text"],input[type="file"]').val('');
	var collapseName = div.find('.accordion-body').attr('id');
	var newId = parseInt(collapseName.split('-')[2])+1;
	div.find('.accordion-body').attr('id','collapse-media-'+newId);
	div.find('.accordion-toggle').attr('href','#collapse-media-'+newId);
	div.find('.accordion-toggle').text('Related Media #'+newId);
	div.find('.show-hide-value').val(0).attr('name','moduleArguments[media]['+newId+'][hidden]');
	div.find('.asset-toggle').attr('data-original-title', 'Hide').addClass('hide-asset asset-clone-toggle').removeClass('show-asset');
	div.find('.asset-toggle').children('i').addClass('icon-eye-close').removeClass('icon-eye-open');
	var a = newId - 1;
	div.find('#originalResource-'+a).attr({
		'name': 'moduleArguments[media]['+newId+'][originalResource]',
		'id': 'originalResource-'+newId
	}).parent().prev('label').attr('for','originalResource-'+newId);
	div.find('#caption-'+a).attr({
		'name': 'moduleArguments[media]['+newId+'][caption]',
		'id': 'caption-'+newId
	}).parent().prev('label').attr('for','caption-'+newId);
	div.find('#copyRight-'+a).attr({
		'name': 'moduleArguments[media]['+newId+'][copyRight]',
		'id': 'copyRight-'+newId
	}).parent().prev('label').attr('for','copyRight-'+newId)
	div.find('#originalResource-'+newId).next('img').remove();
	div.find('#collapse-media-'+newId).removeClass('in').removeAttr("style");
	div.find('.remove-file').remove();
	div.find('.accordion-heading').append('<a class="pull-right remove-file tooltip-demo" rel="tooltip" title="Delete" onclick="deleteClone(this)"><i class="icon-trash"></i></a>');
	jQuery('.add-more-media').before(div);
	jQuery('.asset-clone-toggle').click(function() {
		hideShowTest(this);
	});
	jQuery('.tooltip-demo').tooltip();
};

function deleteClone(el) {
	var confirmDelete = confirm('Are you sure you want to delete?');
	if(confirmDelete) {
		jQuery(el).parent().parent().remove();
	}
};