class HelloWorld {
    constructor() {
        this.message = "Hello Instagram!";
    }
    sayHello() {
        console.log(this.message);
    }
}


if (typeof require !== 'undefined' && require.main === module) {
    var helloWorld = new HelloWorld();
    helloWorld.sayHello();
}

