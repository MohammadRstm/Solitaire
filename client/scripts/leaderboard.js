// initialize document varibles
const leaderBoardTableElem = document.getElementById("leaderboard-container");

// Server base url - (must be hidden in a real project)
const BASE_URL = "http://localhost/solitaire/server";

let scores = [];// scores state 

const displayDuration = (duration) =>{
    if(duration < 60 ){// display in min
        return(`
            ${duration} sec
        `);
    }else{
        const minutes = Math.floor(duration / 60);
        const remaindingSeconds = duration % 60;
        return(`
            ${minutes} : ${remaindingSeconds.toString().padStart(2 , "0")} min
        `);
    }
};

const fetchScores = async () =>{  
    // API CALL TO GET SCORES
    try{
    const response = await axios.get(`${BASE_URL}/api/get_scores.php`);
        scores = response.data;
        if(scores.length > 0){
            leaderBoardTableElem.innerHTML = `
                    <table class = "leaderboard-table">
                        <thead>
                            <th>Full Name</th>
                            <th>Score</th>
                            <th>Duration</th>
                        </thead>
                        <tbody>
                            ${scores.map(sc => (
                                `
                                    <tr>
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
    }catch(err){
        console.log("ERROR FETCHING SCORES : " + err);
    }
};

fetchScores();


