const scoreFormElem = document.getElementById("scoreSubmitButton");
const fullNameInputElem = document.getElementById("fullNameInput");

const BASE_URL = "http://localhost/solitaire/server";

scoreFormElem.addEventListener("click" , async () => {
    const full_name = fullNameInputElem.value;

    if(!full_name){// shouldn't happen
        alert("Please enter your full name");
        return;
    } 
    try{
        const response = await axios.post(`${BASE_URL}/api/create_score.php` , {
            fullName : full_name
        });
        const data = response.data;
        if (data?.success){
            const {score , duration , placement} = data;
            alert(`Your Record have been successfuly added:\nScore --> ${score}\nDuration --> ${displayDuration(duration)}\nPlacement --> ${placement}`);
        }else{
            alert(data?.message);// user friendly message
            console.log(data?.error);// used for debugging
        }
        fullNameInputElem.value = "";
    }catch(err){
        console.log("ERROR SUBMITTING SCORE : " + err);
    }
});