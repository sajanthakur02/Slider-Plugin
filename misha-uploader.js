var imgId = [];

jQuery(document).ready(function ($) {
	
    function printImgId() {
		idImg = imgId.toString();
		$('#img_id').val(idImg);
        console.log('Values of imgId:', imgId.toString());
    }

    // on upload button click
    $(document).on('click', '.rudr-upload', function (event) {
        event.preventDefault(); // prevent default link click and page refresh

        const button = $(this);
        const imageId = button.next().next().val();
        const customUploader = wp.media({
            title: 'Insert image', // modal window title
            library: {
                // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                type: ['image']
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: 'add'
        }).on('select', function () { // it also has "open" and "close" events
            const selection = customUploader.state().get('selection');
            selection.map(function (attachment) {
                attachment = attachment.toJSON();
                ids = attachment.id;
                imgId.push(ids);
            });

            // Call the function to print imgId array
            printImgId();
        });
		console.log(customUploader);
        // already selected images
        customUploader.on('open', function () {
            if (imageId) {
                const selection = customUploader.state().get('selection');
                attachment = wp.media.attachment(imageId);
                attachment.fetch();
                selection.add(attachment ? [attachment] : []);
            }
        });

        customUploader.open();
    });

    // on remove button click
    $(document).on('click', '.rudr-remove', function (event) {
        event.preventDefault();
        const button = $(this);
        button.next().val(''); // emptying the hidden field
        button.hide().prev().addClass('button').html('Upload image'); // replace the image with text
    });

    // Call the function to print initial imgId array (empty array)
    printImgId();
});
