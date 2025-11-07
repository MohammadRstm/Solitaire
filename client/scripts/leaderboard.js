// initialize document varibles
const leaderBoardTableElem = document.getElementById("leaderboard-container");

// Server base url - (must be hidden in a real project)
const BASE_URL = "http://localhost/solitaire/server";

let scores = [];// scores state 


const fetchScores = async () =>{  
    // API CALL TO GET SCORES
    try{
    const response = await axios.get(`${BASE_URL}/api/get_scores.php`);
    const data = response.data;
    if(data?.success){
        scores = data.scores;
        if(scores.length > 0){
            leaderBoardTableElem.innerHTML = `
                    <table class = "leaderboard-table">
                        <thead>
                            <th>Rank</th>
                            <th>Full Name</th>
                            <th>Score</th>
                            <th>Duration</th>
                        </thead>
                        <tbody>
                            ${scores.map((sc,ind) => (
                                `
                                    <tr>
                                        <td>${ind + 1}</td>
                                        <td>${sc.full_name}</td>
                                        <td>${sc.score}</td>
                                        <td>${displayDuration(sc.duration)}</td>
                                    </tr>
                                `
                            )).join("")}
                        </tbody>
                    </table>
                `;
        }else{
            leaderBoardTableElem.innerHTML = `
                    <p class= "no-scores-header">
                    No scores yet, head to the 
                    <a href ="../index.html">landing page </a>
                    to add yours!
                    </p>
                `;
        }
    }else{
        alert(data?.message);
        console.log(data?.error);
    }
    }catch(err){
        console.log("ERROR FETCHING SCORES : " + err);
    }
};

fetchScores();


