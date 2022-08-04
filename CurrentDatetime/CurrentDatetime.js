class CurrentTime {
    constructor() {
        this.now = this.currentTime();
    }
    currentTime() {
        var date = new Date();
        var time = `${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
        var today = `${date.getDate()}-${date.getMonth()+1}-${date.getFullYear()}`;
        return `${today} ${time}`;
    }
}


if (typeof require !== 'undefined' && require.main === module) {
    var currentTime = new CurrentTime();
    console.log(currentTime.now);
}

