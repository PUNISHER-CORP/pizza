var $collectionHolder;

// setup an "add a tag" link
var $addTagButton = $('<button type="button" class="btn btn-success add_tag_link">Добавить</button>');
var $newLinkLi = $('<li></li>').append($addTagButton);

jQuery(document).ready(function() {
    $collectionHolder = $('ul.images');
    let $collectionLi = $collectionHolder.find('li');

    //FIXME DOMSubtreeModified является устаревшим, следует заменить на что-то новое
    $collectionHolder.bind("DOMSubtreeModified",function(){
        let $collectionLi = $(this).find('li');
        if($collectionLi.length >= 3){
            $addTagButton.hide();
        }else{
            $addTagButton.show();
        }
    });

    $collectionLi.each(function() {
        addTagFormDeleteLink($(this));
    });

    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find('input').length);

    $addTagButton.on('click', function(e) {
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button type="button" class="btn btn-danger">Удалить</button>');
    $tagFormLi.find('.image-container .custom-file').append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}
