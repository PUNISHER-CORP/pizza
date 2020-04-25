function initializeCollection (ulClass, itemClass) {
    let $collectionHolder;
    let $addTagButton = $('<button type="button" class="btn btn-success add_tag_link">Добавить</button>');
    let $newLinkLi = $('<li></li>').append($addTagButton);

    $collectionHolder = $('ul.' + ulClass);
    let $collectionLi = $collectionHolder.find('li');

    $collectionLi.each(function () {
        addTagFormDeleteLink($(this), itemClass);
    });

    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find('select').length);

    $addTagButton.on('click', function (e) {
        addTagForm($collectionHolder, $newLinkLi, itemClass);
    });
}

function addTagForm($collectionHolder, $newLinkLi, itemClass) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    newForm = newForm.replace(/__name__label__/g, index);
    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<li class="' + itemClass + ' collection-item"></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi, itemClass);
}

function addTagFormDeleteLink($tagFormLi, itemClass) {
    var $removeFormButton = $('<button type="button" class="btn btn-danger delete__button">Удалить</button>');

    if($tagFormLi.hasClass(itemClass)){
        $tagFormLi.append($removeFormButton);
    }

    $removeFormButton.on('click', function(e) {
        $tagFormLi.remove();
    });
}