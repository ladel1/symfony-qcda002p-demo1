var checkNode = document.querySelector("#article_autre");
if(checkNode.checked){
    document.querySelector("#article div:nth-child(6)").style="display:flex";
}

checkNode.addEventListener("change",function(event){
    if(this.checked){
        document.querySelector("#article div:nth-child(6)").style="display:flex";
    }else{
        document.querySelector("#article div:nth-child(6)").style="display:none";
        document.querySelector("#article_category_name").value="";
    }
});