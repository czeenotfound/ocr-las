
//Store hooks and video sizes:
const video = document.getElementById('webcam');
const liveView = document.getElementById('liveView');
const demosSection = document.getElementById('demos');
const enableWebcamButton = document.getElementById('webcamButton');
const modalCloseButton = document.querySelector('[data-bs-dismiss="modal"]');
const modal = document.getElementById('SCANIDModal');
const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0)
const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)
var vidWidth = 0;
var vidHeight = 0;
var xStart = 0;
var yStart = 0;



const captureSize = {
  w: 300,
  h: 90
}; //pxels


//Creating canvas for OCR:
const c = document.createElement('canvas');
//const c = document.getElementById('canvas');
c.width = captureSize.w;
c.height = captureSize.h;
var click_pos = {
  x: 0,
  y: 0
};

var mouse_pos = {
  x: 0,
  y: 0
};

//Glob flag to indicate that detection is needed:
// No longer needed: var Analyzef = false;

//----------Put video on canvas:
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');




//----Video capturing part:

//Render frame handler
function renderFrame() {
  
  // re-register callback
  requestAnimationFrame(renderFrame);
  
  // set internal canvas size to match HTML element size
  canvas.width = canvas.scrollWidth;
  canvas.height = canvas.scrollHeight;
  
  if (video.readyState === video.HAVE_ENOUGH_DATA) {
    
    // scale and horizontally center the camera image
    var videoSize = {
      width: video.videoWidth,
      height: video.videoHeight
    };
    var canvasSize = {
      width: canvas.width,
      height: canvas.height
    };
    var renderSize = calculateSize(videoSize, canvasSize);
    var xOffset = 0; 
    var yOffset = 0; 

    context.drawImage(video, xOffset, yOffset, renderSize.width, renderSize.height);

    // Draw scan area border (centered)
    const scanW = captureSize.w;
    const scanH = captureSize.h;
    const scanX = (canvas.width - scanW) / 2;
    const scanY = (canvas.height - scanH) / 2;
    context.save();
    context.strokeStyle = '#00FF00';
    context.lineWidth = 3;
    context.strokeRect(scanX, scanY, scanW, scanH);
    context.restore();
  }
}



// Function to enable the start button
function enableStartButton() {
  enableWebcamButton.classList.remove('removed');
}

// Add an event listener to the modal close button
modalCloseButton.addEventListener('click', function() {
  // Stop the webcam stream
  stopWebcam();
  // Enable the start button
  enableStartButton();
});

// Add an event listener to the document body to capture clicks
document.body.addEventListener('click', function(event) {
  // Check if the clicked element is outside of the modal
  if (!modal.contains(event.target) && event.target !== enableWebcamButton) {
    // Stop the webcam stream
    stopWebcam();
    // Enable the start button
    enableStartButton();
  }
});

// Check if webcam access is supported.
function getUserMediaSupported() {
  return !!(navigator.mediaDevices &&
    navigator.mediaDevices.getUserMedia);
}

// If webcam supported, add event listener to activation button:
if (getUserMediaSupported()) {
  enableWebcamButton.addEventListener('click', enableCam);
} else {
  console.warn('getUserMedia() is not supported by your browser');
}

let scanInterval = null;
let scanDelay = 5000; // 5 seconds
let scanReady = false;

//Function to enable the live webcam view and start detection
function enableCam(event) {
  // Enable click event
  // canvas.addEventListener("mousedown", Capture); // Removed

  // Hide the button once clicked
  enableWebcamButton.classList.add('removed');

  // getUsermedia parameters to force video but not audio
  const constraints = {
    video: true
  };

  // Stream video from VAR (for safari also)
  navigator.mediaDevices.getUserMedia({
    video: {
      facingMode: "environment"
    },
  }).then(stream => {
    let $video = document.querySelector('video');
    $video.srcObject = stream;

    $video.onloadedmetadata = () => {
      vidWidth = $video.videoHeight;
      vidHeight = $video.videoWidth;

      //The start position of the video (from top left corner of the viewport)
      xStart = Math.floor((vw - vidWidth) / 2);
      yStart = (Math.floor((vh - vidHeight) / 2) >= 0) ? (Math.floor((vh - vidHeight) / 2)) : 0;

      $video.play();

      //Hook the detection on loading data to video element
      $video.addEventListener('loadeddata', predictWebcamTF);
      renderFrame();
    }
  });
  // Reset scan state
  scanReady = false;
  if (scanInterval) {
    clearInterval(scanInterval);
    scanInterval = null;
  }
}

// Add an event listener to the modal close button
modalCloseButton.addEventListener('click', function() {
  // Stop the webcam stream
  stopWebcam();
});

// Function to stop the webcam stream
function stopWebcam() {
  // Stop the video stream tracks
  const videoTracks = document.querySelector('video').srcObject.getVideoTracks();
  videoTracks.forEach(track => track.stop());
  // Clear scan interval
  if (scanInterval) {
    clearInterval(scanInterval);
    scanInterval = null;
  }
  scanReady = false;
}

// Add an event listener to the document body to capture clicks
document.body.addEventListener('click', function(event) {
  // Check if the clicked element is outside of the modal
  if (!modal.contains(event.target) && event.target !== enableWebcamButton) {
    // Stop the webcam stream
    stopWebcam();
  }
});

//-----Detection part:
//Async load of tessaract model
Init(); 

var children = [];
//Perform prediction based on webcam using Layer model model:
function predictWebcamTF() {
  if (!scanReady) {
    scanReady = true;
    setTimeout(() => {
      scanInterval = setInterval(() => {
        detectTFMOBILE(video);
      }, scanDelay);
    }, scanDelay); // Wait 5 seconds before first scan
  }
  // Continue rendering frames for the video/canvas
  window.requestAnimationFrame(predictWebcamTF);
}



//Image detects object that matches the preset:
async function detectTFMOBILE(imgToPredict) {
  // Always scan the center area of the canvas
  const scanW = captureSize.w;
  const scanH = captureSize.h;
  const scanX = (canvas.width - scanW) / 2;
  const scanY = (canvas.height - scanH) / 2;
  // Draw the scan area from the canvas to the temp canvas c
  c.getContext('2d').drawImage(canvas, scanX, scanY, scanW, scanH, 0, 0, scanW, scanH);
  // Optionally, you can show a highlight or animation here
  // Perform OCR on the scan area
  await Recognize(c);
}



//-----UI and Utils part:


//Mark the OCR area:
function MarkAreaSimple(minX, minY, width_, height_) {
  var highlighter = document.createElement('div');
  highlighter.setAttribute('class', 'highlighter_s');

  highlighter.style = 'left: ' + minX + 'px; ' +
    'top: ' + minY + 'px; ' +
    'width: ' + width_ + 'px; ' +
    'height: ' + height_ + 'px;';
  
  liveView.appendChild(highlighter);
  children.push(highlighter);

  return highlighter;
}

//Helper function for marking OCR area helper:
function MarkArea(minX, minY, width_, height_, text) {

  var highlighter = document.createElement('div');
  highlighter.setAttribute('class', 'highlighter');

  highlighter.style = 'left: ' + minX + 'px; ' +
    'top: ' + minY + 'px; ' +
    'width: ' + width_ + 'px; ' +
    'height: ' + height_ + 'px;';
  highlighter.innerHTML = '<p>' + text + '</p>';
  
  liveView.appendChild(highlighter);
  
  children.push(highlighter);

  if (text.length < 1) {
    liveView.removeChild(highlighter);
  } else {
    setTimeout(() => {
      liveView.removeChild(highlighter);
    }, 5000);
  }
}


//Streching image on canvas:
function calculateSize(srcSize, dstSize) {
  var srcRatio = srcSize.width / srcSize.height;
  var dstRatio = dstSize.width / dstSize.height;
  if (dstRatio > srcRatio) {
    return {
      width: dstSize.height * srcRatio,
      height: dstSize.height
    };
  } else {
    return {
      width: dstSize.width,
      height: dstSize.width / srcRatio
    };
  }
}


// No longer needed: Capture function (removed)


function getCursorPosition(canvas, event) {
  
  const rect = canvas.getBoundingClientRect()
  const x = event.clientX - rect.left
  const y = event.clientY - rect.top
  return {x,y};
}