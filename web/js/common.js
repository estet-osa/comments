"use strict";

var d = document, w = window;

var cmt = {

    getId : function(id) {
        return d.getElementById(id);
    },

    create : function(elem) {
        return d.createElement(elem)
    },

    remove : function (elem) {

        var list    = this.getId('comments'),
            parent  = elem.parentNode.parentNode.parentNode,
            currId  = parent.getAttribute('data-comment-id');

        parent.className = 'active';

        setTimeout(function(){
            list.removeChild(parent);
        }, 600);

        $.ajax({
            type     : 'POST',
            url      : '/comment/del',
            data     : { commentId : currId },
            success  : function(data) {
                // ...
            }
        });
    },

    validMail : function() {
        var regExp  = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/,
            myMail  = $('#comment_email').val();

        if(regExp.test(myMail)) return true;
        else alert('Исправьте email');
    },

    validOwner : function(){

        if($('#comment_owner').val() != ''){
            return true;
        }else
            alert('Пожалуйста заполните Имя');
    },

    validMsg : function(){

        if($('#comment_msg').val() != ''){
            return true;
        }else
            alert('Пожалуйста добавьте комментарий');
    },

    send : function() {

        var comments_list = this.getId('comments');

        if(this.validOwner() && this.validMail() && this.validMsg()) {
            $.ajax({
                type: 'POST',
                url: '/comment/add',
                data: {
                    owner   : $('#comment_owner').val(),
                    email   : $('#comment_email').val(),
                    msg     : $('#comment_msg').val(),
                },
                success : function(data) {
                    if (data != 'error') {
                        comments_list.appendChild(cmt.newComment(data));

                        cmt.clearForm(); // Clear form after response data

                        $('html, body').animate({
                            scrollTop: $('#comment' + data).offset().top
                        }, 1000);
                    }
                }
            });

            return false;

        }else
            return false;

    },

    /**
     * Clear form data
     */
    clearForm : function(){
        $('#comment_owner').val('');
        $('#comment_email').val('');
        $('#comment_msg').val('');
    },

    newComment : function(currId) {

        var LI      = this.create('LI'),
            WRAPPER = this.create('DIV'),
            HIDE    = this.create('DIV'),
            CIRCLE  = this.create('DIV'),
            OWNER   = this.create('DIV'),
            RM_WRP  = this.create('DIV'),
            RM_IMG  = this.create('IMG'),
            NAME    = this.create('SPAN'),
            MAIL_WRP= this.create('DIV'),
            MAIL    = this.create('SPAN'),
            COMMENT = this.create('DIV');

        LI.setAttribute('data-comment-id', currId);
        LI.setAttribute('id', 'comment' + currId);
        WRAPPER.className   = 'wrapper';
        HIDE.className      = 'hide';
        CIRCLE.className    = 'circle';
        OWNER.className     = 'owner';
        RM_WRP.className    = 'remove_current';
        RM_WRP.setAttribute('onclick', 'cmt.remove(this)');
        RM_IMG.src = '/img/close_white.gif';
        NAME.className      = 'name';
        NAME.innerHTML      = this.getId('comment_owner').value.trim();
        MAIL_WRP.className  = 'owner_mail';
        MAIL.innerHTML      = this.getId('comment_email').value.trim();
        COMMENT.className   = 'msg';
        COMMENT.innerHTML   = this.getId('comment_msg').value.trim();

        LI.appendChild(WRAPPER);
        WRAPPER.appendChild(HIDE);
        HIDE.appendChild(CIRCLE);
        WRAPPER.appendChild(OWNER);
        OWNER.appendChild(RM_WRP);
        RM_WRP.appendChild(RM_IMG);
        OWNER.appendChild(NAME);
        WRAPPER.appendChild(MAIL_WRP);
        MAIL_WRP.appendChild(MAIL);
        WRAPPER.appendChild(COMMENT);

        return LI;
    }
};
