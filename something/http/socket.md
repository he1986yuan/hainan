##web socket协议简介

一、Socket简介
Socket是进程通讯的一种方式，即调用这个网络库的一些API函数实现分布在不同主机的相关进程之间的数据交换。
几个定义：
（1）IP地址：即依照TCP/IP协议分配给本地主机的网络地址，两个进程要通讯，任一进程首先要知道通讯对方的位置，即对方的IP。
（2）端口号：用来辨别本地通讯进程，一个本地的进程在通讯时均会占用一个端口号，不同的进程端口号不同，因此在通讯前必须要分配一个没有被访问的端口号。
（3）连接：指两个进程间的通讯链路。
（4）半相关：网络中用一个三元组可以在全局唯一标志一个进程：
（协议，本地地址，本地端口号）
这样一个三元组，叫做一个半相关,它指定连接的每半部分。
（4）全相关：一个完整的网间进程通信需要由两个进程组成，并且只能使用同一种高层协议。也就是说，不可能通信的一端用TCP协议，而另一端用UDP协议。因此一个完整的网间通信需要一个五元组来标识：
（协议，本地地址，本地端口号，远地地址，远地端口号）
这样一个五元组，叫做一个相关（association），即两个协议相同的半相关才能组合成一个合适的相关，或完全指定组成一连接。
二、客户/服务器模式
在TCP/IP网络应用中，通信的两个进程间相互作用的主要模式是客户/服务器（Client/Server, C/S）模式，即客户向服务器发出服务请求，服务器接收到请求后，提供相应的服务。客户/服务器模式的建立基于以下两点：
（1）首先，建立网络的起因是网络中软硬件资源、运算能力和信息不均等，需要共享，从而造就拥有众多资源的主机提供服务，资源较少的客户请求服务这一非对等作用。
（2）其次，网间进程通信完全是异步的，相互通信的进程间既不存在父子关系，又不共享内存缓冲区，因此需要一种机制为希望通信的进程间建立联系，为二者的数据交换提供同步，这就是基于客户/服务器模式的TCP/IP。
服务器端：
其过程是首先服务器方要先启动，并根据请求提供相应服务：
（1）打开一通信通道并告知本地主机，它愿意在某一公认地址上的某端口（如FTP的端口可能为21）接收客户请求；
（2）等待客户请求到达该端口；
（3）接收到客户端的服务请求时，处理该请求并发送应答信号。接收到并发服务请求，要激活一新进程来处理这个客户请求（如UNIX系统中用fork、exec）。新进程处理此客户请求，并不需要对其它请求作出应答。服务完成后，关闭此新进程与客户的通信链路，并终止。
（4）返回第（2）步，等待另一客户请求。
（5）关闭服务器
客户端：
（1）打开一通信通道，并连接到服务器所在主机的特定端口；
（2）向服务器发服务请求报文，等待并接收应答；继续提出请求......
（3）请求结束后关闭通信通道并终止。
从上面所描述过程可知：
（1）客户与服务器进程的作用是非对称的，因此代码不同。
（2）服务器进程一般是先启动的。只要系统运行，该服务进程一直存在，直到正常或强迫终止。


#通俗的讲socket的协议的过程
就是两个进程，跨计算机，他俩需要通讯的话，需要通过网络对接起来。
这就是 socket 的作用。打个比方吧，两个进程在两个计算机上，需要有一个进程做被动方，叫做服务器。另一个做主动方，叫做客户端。他们位于某个计算机上，叫做主机 host ，在网络上有自己的 ip 地址。一个计算机上可以有多个进程作为服务器，但是 ip 每个机器只有一个，所以通过不同的 port 数字加以区分。
因此，服务器程序需要绑定在本机的某个端口号上。客户端需要声明自己连接哪个地址的那个端口。两个进程通过网络建立起通讯渠道，然后就可以通过 recv send 来收发一些信息，完成通讯。

所以 socket 就是指代承载这种通讯的系统资源的标识。
AgularAngular

与HTTP比较

同样作为应用层的协议，WebSocket在现代的软件开发中被越来越多的实践，和HTTP有很多相似的地方，这里将它们简单的做一个纯个人、非权威的比较：

相同点

--都是基于TCP的应用层协议。
--都使用Request/Response模型进行连接的建立。
--在连接的建立过程中对错误的处理方式相同，在这个阶段WS可能返回和HTTP相同的返回码。
--都可以在网络中传输数据。
不同点

--WS使用HTTP来建立连接，但是定义了一系列新的header域，这些域在HTTP中并不会使用。
--WS的连接不能通过中间人来转发，它必须是一个直接连接。
--WS连接建立之后，通信双方都可以在任何时刻向另一方发送数据。
--WS连接建立之后，数据的传输使用帧来传递，不再需要Request消息。
--WS的数据帧有序。