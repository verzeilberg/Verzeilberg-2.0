/**
 * Make checklist fields sortable
 */
$('.sortable').nestedSortable({
    disableNesting: 'no-nest',
    forcePlaceholderSize: true,
    handle: 'div',
    helper: 'clone',
    items: 'li',
    maxLevels: 0,
    opacity: .6,
    placeholder: 'placeholder',
    revert: 250,
    tabSize: 25,
    tolerance: 'pointer',
    toleranceElement: '> div',
    placeholder: "ui-state-highlight",
    relocate: function (event, ui) {
        list = $(this).nestedSortable('toHierarchy', {startDepthCount: 0, excludeRoot: true});
        $.ajax({
            type: 'POST',
            data: {
                list: list,
            },
            url: "/menuajax/orderMenuItems",
            async: true,
            success: function (data) {
                if (data.success === true) {
                } else {
                    alert('fout');
                }

            }
        });
    }
});

$("a.delete-menu-item").on( "click", function(event) {
    event.preventDefault();
    let menuItemId = $(this).data('menuitemid');
    let menuId     = $(this).data('menuid');
    $.ajax({
        type: 'POST',
        data: {
            menuitemid: menuItemId,
            menuid:     menuId
        },
        url: "/menuajax/deleteMenuItem",
        async: true,
        success: function (data) {
            console.log(data);
            if (data.success === true) {
                $('li#menuItem_' + menuItemId).remove();
            } else {
                alert(data.errorMessage);
            }

        }
    });
} );
