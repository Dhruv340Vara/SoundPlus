

    function searchFunction(){

            let query=document.getElementById("search-bar").value;

            if(query.length > 1){
                let xhr=new XMLHttpRequest();
                xhr.open("GET","search.php?q="+query,true);

                xhr.onreadystatechange=function(){
                
                if(xhr.readyState === 4 && xhr.status === 200);
                {
                    document.getElementById("result-box").innerHTML=xhr.responseText;
                }
                };
            xhr.send();
            }
          else{
              document.getElementById("result-box").innerHTML="";
          }
    }

    //fetch song category
    function fetchSongs(category){ 
        var xhr=new XMLHttpRequest();
        xhr.open("GET","home.php?category=" + category + "&ajax=true",true);

        xhr.onreadystatechange=function()
        {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
         
                var response=JSON.parse(xhr.responseText);
                document.getElementById("category-title").textContent=response.category+" Songs";
                document.getElementById("songs-container").innerHTML=response.html; 

            }
        
        };
        xhr.send();
    }
    
    
    //document.addEventListener("DOMContentLoaded",
    function myfun() {

        document.querySelectorAll(".menu-btn").forEach(button => {
            button.addEventListener("click",function(event){
                let menu=this.nextElementSibling;
                menu.style.display=(menu.style.display === "block") ? "none":"block";

                //close other menus

                document.querySelectorAll(".menu-dropdown").forEach(m => {
                    if(m !== menu){
                        m.style.display="none";
                    }
                });
                event.stopPropagation();
            });
        });
        //hide menu when clicking anywhere else

        document.addEventListener("click",function() {
            document.querySelectorAll(".menu-dropdown").forEach(menu => {
                menu.style.display="none";
            });
        });
    };


    document.addEventListener("DOMContentLoaded",function() {

        document.querySelectorAll(".menu-btn").forEach(button => {
            button.addEventListener("click",function(event){
                let menu=this.nextElementSibling;
                menu.style.display=(menu.style.display === "block") ? "none":"block";

                //close other menus

                document.querySelectorAll(".menu-dropdown").forEach(m => {
                    if(m !== menu){
                        m.style.display="none";
                    }
                });
                event.stopPropagation();
            });
        });
        //hide menu when clicking anywhere else

        document.addEventListener("click",function() {
            document.querySelectorAll(".menu-dropdown").forEach(menu => {
                menu.style.display="none";
            });
        });
    });
