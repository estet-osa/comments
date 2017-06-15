var d = document;

var cmt = {

    getId : function(id) {
        return d.getElementById(id);
    },

    remove : function (elem) {

        var list    = this.getId('comments'),
            parent  = elem.parentNode.parentNode.parentNode,
            currId  = parent.getAttribute('data-comment-id');

        parent.className = 'active';

        setTimeout(function(){
            list.removeChild(parent);
        }, 600);
    }
};
