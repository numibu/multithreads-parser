*in developing ...*

 This a realistic way of implementing a multi-threaded html-parser in PHP, or you can just simulating it with pthreads-polyfill 
 [krakjoe/pthreads-polyfill](github.com/krakjoe/pthreads-polyfill). 

Some time back it was suggested that you could force the operating system to load another instance of the PHP executable and handle other simultaneous processes.

But a pthreads ofered another way - real multithread interface in php.

>**Note** </br>
_All treads in php is absolute isolated, and must returnet primitive or Volatile class instance._

>**Warning** </br>
_The extension based on pthreads cannot be used in a web server environment. Threading in PHP should therefore remain to CLI-based applications only._

**dependis:**
- php7.1+ (zts enabled);
- pthreads >3.1.6;
- CURL;
