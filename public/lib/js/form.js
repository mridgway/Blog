$(document).ready(function () {
    var config = {};
    config.toolbar =
        [
            ['Styles', 'Format', 'Font', 'FontSize'],
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
            ['TextColor','BGColor'],
            ['Link','Unlink','Anchor']
        ];
    config.width = '100%'
    config.resize_minWidth = '100%'
    config.resize_maxWidth = '100%'
    $('textarea.rte').ckeditor(config);
});