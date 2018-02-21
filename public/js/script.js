// // /* Start Ajax */
let getHttpRequest = function () {
    var httpRequest = false;

    httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
        alert('Abandon :( Impossible de créer une instance XMLHTTP');
        return false;
    }
    return httpRequest
}
// // var form = document.querySelector('#formlogin')
// // form.addEventListener('submit',function (e) {

// //     e.preventDefault()
// //     var httpRequest = getHttpRequest()
// //     httpRequest.onreadystatechange = function () {
// //         if (this.readyState === 4) {
// //             if(httpRequest.status === 200)
// //             {
// // 				document.querySelector('#result').innerHTML = httpRequest.responseText


// //             }
// //             else{
// //                 alert('Error')
// //             }
// //         }
// //     }

// // 	httpRequest.open('POST', '/login', true)
	
// //     let data = new FormData(form)

// //     httpRequest.send(data)        
// // })
// /* End Ajax */

// input submit pointage bsp
document.querySelector('#pointage-bsp').addEventListener('click',function (e)
{
    
    e.preventDefault()

    document.querySelector("#result").text = "";
    document.querySelector("#regenerer-vente").style.display = "inline"

    let fileInput = document.getElementById("file-input-pointage");

    let files = fileInput.files

    let inputtextpointage = document.querySelector("#inputtextpointage")
    
    // get file input name*
    fileInput.addEventListener('change',function(){
        inputtextpointage.value= fileInput.value.split(/(\\|\/)/g).pop()
    });
    
    var httpRequest = getHttpRequest()
    httpRequest.onreadystatechange = function () {
        if (this.readyState === 4) {
            if(httpRequest.status === 200)
            {
				document.querySelector('#result').innerHTML = httpRequest.responseText
                document.querySelector('.spinner').style.display = 'none'

            }
            else{
                alert('Error')
            }
        }
        else if(this.readyState === 1)
        {
            document.querySelector('.spinner').style.display = 'block'
        }
    }

	httpRequest.open('POST', '/pointage-bsp', true)
	
    let data = new FormData(formpointagevente)

    httpRequest.send(data)
     
});

// input submit pointage vente
document.querySelector('#pointeur-vente').addEventListener('click',function (e)
{

    e.preventDefault()

    document.querySelector("#result").text = ""
    document.querySelector("#regenerer-vente").style.display = "inline"

    let fileInput = document.getElementById("file-input-pointage")

    let files = fileInput.files

    let inputtextpointage = document.querySelector("#inputtextpointage")
    
    // get file input name*
    inputtextpointage.value= fileInput.value.split(/(\\|\/)/g).pop()
    var httpRequest = getHttpRequest()
    httpRequest.onreadystatechange = function () {
        if (this.readyState === 4) {
            if(httpRequest.status === 200)
            {
				document.querySelector('#result').innerHTML = httpRequest.responseText


            }
            else{
                alert('Error')
            }
        }
    }

	httpRequest.open('POST', '/pointage-vente', true)
	
    let data = new FormData(formpointagevente)

    httpRequest.send(data)
     
});


    
document.querySelector('#pointeur-vente').addEventListener('click',function (e){
    e.preventDefault()

});