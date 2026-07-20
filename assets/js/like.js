function likePost(btn){


    let cid = btn.dataset.cid;


    fetch(
        likeUrl,
        {
            method:"POST",

            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:
            "cid="+cid
        }
    )


    .then(res=>res.json())


    .then(data=>{


        btn.querySelector("#like-count")
        .innerHTML=data.count;


        btn.disabled=true;


    });


}