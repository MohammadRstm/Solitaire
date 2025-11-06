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