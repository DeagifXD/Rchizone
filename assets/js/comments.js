document.addEventListener("DOMContentLoaded", function() {
    
    const commentForm = document.getElementById("comment-form");
    const textarea = document.getElementById("textarea");
    const commentParentInput = document.getElementById("comment-parent");
    const replyNotification = document.getElementById("reply-notification");
    const replyAuthorName = document.getElementById("reply-author-name");
    const cancelReplyBtn = document.getElementById("cancel-reply-btn");
    const commentAuthorInput = document.getElementById("comment-author");
    const commentEmailInput = document.getElementById("comment-email");
    const commentUrlInput = document.getElementById("comment-url");
    const commentSubmitBtn = document.getElementById("comment-submit-btn");

    
    if (!commentForm || !textarea || !cancelReplyBtn) {
        console.warn("评论表单元素不完整，评论功能已禁用");
        return; 
    }

    
    const originalFormState = {
        parent: 0,
        text: "",
        author: commentAuthorInput ? commentAuthorInput.value : "",
        email: commentEmailInput ? commentEmailInput.value : "",
        url: commentUrlInput ? commentUrlInput.value : ""
    };

    
    let submitTimeoutId = null;
    let resetTimeoutId = null;
    
    
    let initialized = false;
    
    let isSubmitting = false;

    
    const isAfterSubmit = sessionStorage.getItem('commentSubmitted');
    
    
    if (isAfterSubmit) {
        sessionStorage.removeItem('commentSubmitted');
        isSubmitting = false;
    }

    const handleReplyClick = function(e) {
        if (e.target.classList.contains("comment-reply-btn")) {
            e.preventDefault();
            
            const coid = e.target.dataset.coid;
            const author = e.target.dataset.author;

            if (!coid || !author) {
                console.warn("回复数据不完整");
                return;
            }

            
            commentParentInput.value = coid;
            
            
            replyAuthorName.textContent = author;
            replyNotification.style.display = "block";

            
            textarea.focus();
            
            
            commentForm.scrollIntoView({ behavior: "smooth", block: "center" });
        }
    };

    const handleCancelReply = function(e) {
        e.preventDefault();
        resetReplyState();
    };

    const handleFormSubmit = function(e) {
        if (isSubmitting) {
            e.preventDefault();
            console.warn("评论正在提交中，请勿重复提交");
            return false;
        }

        const parentId = parseInt(commentParentInput.value, 10);
        
        
        if (parentId > 0) {
            if (isNaN(parentId) || parentId < 1) {
                e.preventDefault();
                alert("父评论ID无效，请重新选择");
                return false;
            }
        }

        if (!textarea.value.trim()) {
            e.preventDefault();
            alert("请输入评论内容");
            return false;
        }

        
        const originalBtnText = commentSubmitBtn.textContent;
        commentSubmitBtn.disabled = true;
        commentSubmitBtn.textContent = "发送中...";

        isSubmitting = true;

        
        if (submitTimeoutId) {
            clearTimeout(submitTimeoutId);
        }
        if (resetTimeoutId) {
            clearTimeout(resetTimeoutId);
        }

        
        sessionStorage.setItem('commentSubmitted', 'true');

        resetTimeoutId = setTimeout(function() {
            console.error("评论提交超时，请检查服务器");
            commentSubmitBtn.disabled = false;
            commentSubmitBtn.textContent = originalBtnText;
            isSubmitting = false;
            sessionStorage.removeItem('commentSubmitted');
            resetTimeoutId = null;
        }, 30000);

        const handleBeforeUnload = function() {
            if (submitTimeoutId) {
                clearTimeout(submitTimeoutId);
            }
            if (resetTimeoutId) {
                clearTimeout(resetTimeoutId);
            }
            window.removeEventListener('beforeunload', handleBeforeUnload);
        };
        
        window.addEventListener('beforeunload', handleBeforeUnload);

        return true; 
    };


    function resetReplyState() {
        commentParentInput.value = 0;
        replyNotification.style.display = "none";
        textarea.value = "";
        
        
        if (commentAuthorInput) {
            commentAuthorInput.value = originalFormState.author;
        }
        if (commentEmailInput) {
            commentEmailInput.value = originalFormState.email;
        }
        if (commentUrlInput) {
            commentUrlInput.value = originalFormState.url;
        }

        textarea.focus();
    }


    function handleSuccessfulSubmit() {
        if (isAfterSubmit) {
            alert("发送成功");
            
            setTimeout(function() {
                resetReplyState();
                
                isSubmitting = false;
                commentSubmitBtn.disabled = false;
                commentSubmitBtn.textContent = "发送";
                
                const commentsSection = document.querySelector('.comment-container');
                if (commentsSection) {
                    commentsSection.scrollIntoView({ behavior: "smooth", block: "start" });
                }
            }, 500);
        }
    }

    function initializeEventListeners() {
        if (initialized) {
            return; 
        }

        initialized = true;

        
        document.addEventListener("click", handleReplyClick);

        
        cancelReplyBtn.addEventListener("click", handleCancelReply);

        
        commentForm.addEventListener("submit", handleFormSubmit);

        
        handleSuccessfulSubmit();
    }

    
    initializeEventListeners();
});