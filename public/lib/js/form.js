$(document).ready(function () {
    var RTEconfig = {};
    RTEconfig.toolbar =
        [
            ['Source'], ['Code'],
            ['Styles', 'Format', 'Font', 'FontSize'],
            ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
            ['TextColor','BGColor'],
            ['Link','Unlink','Anchor']
        ];
    RTEconfig.extraPlugins = 'syntaxhighlight';
    RTEconfig.width = '100%';
    RTEconfig.resize_minWidth = '100%';
    RTEconfig.resize_maxWidth = '100%';
    $('textarea.rte').ckeditor(RTEconfig);
});