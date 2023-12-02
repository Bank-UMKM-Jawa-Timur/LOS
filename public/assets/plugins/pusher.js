Pusher.logToConsole = true;
export const pusher = (channels) => {
    var pusher = new Pusher("fd114c25a90cd2005634", {
        cluster: "ap1",
    });
    return pusher.subscribe("channels");
};
