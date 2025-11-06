const scoreFormElem = document.getElementById("scoreForm");


scoreFormElem.addEventListener("submite" , (e) => {
    e.preventDefault();

    const full_name = scoreFormElem.fullName.value;
    if(!full_name){
        alert("Please enter your full name");
        return;
    } 

    axios.post(`${BASE_URL}/api/create_score` , {
        fullName : full_name
    })
    .then(response => {// must return score and duration
        alert("Score added successfuly\nYour Score = ");
    })
    .catch(err =>{
        console.log("ERROR CREATING SCORE : " + err);
    });
});