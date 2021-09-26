function getId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
    const match = url.match(regExp);

    return (match && match[2].length === 11)
        ? match[2]
        : null;
}

const videoId = getId('http://www.youtube.com/watch?v=zbYf5_S7oJo');
const iframeMarkup = '<iframe width="560" height="315" src="//www.youtube.com/embed/'
    + videoId + '" frameborder="0" allowfullscreen></iframe>';

console.log('Video ID:', videoId);