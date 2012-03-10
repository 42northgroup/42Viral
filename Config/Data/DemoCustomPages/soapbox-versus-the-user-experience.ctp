<!-- Jason Snider May 13, 2010 -->
<div><p>
    In the early days of my career I had an what I now believe to have been an
    irrational focus on "cross browser compatibility" and "standards compliance".
    Please don't get me wrong, I'm not suggesting these are not important or even
    critical concepts. I'm suggesting many of us missed the point. These ideas
    turned to beliefs, which ultimitly became political and nearly religious lines
    in the sand.
    </p>

    <p>
    When I started my life as a web developer IE6 was still in its 90% plus market
    share phase and FireFox was just starting to get noticed. In those days the
    web was a different place. We didn't
    build to the W3C reccomendation, we would build to IE's specs,. Because tha's
    what everyone used, and it's what worked. Additonaly, webpages were still mostly
    top down style HTML documents and user interaction was limited to message
    boards and shopping carts. I refer to this as the "WebDoc" era. AJAX
    wasn't yet the norm, in short, we were not dealing with web applications,
    we were dealing with web documents. There was also an attitude that that
    stated my website must look and function EXACTLY the same in FireFox and
    Netscape as it did in IE6.
    </p>

    <p>Over the next couple of years we started to see a trasition from  the
    "WebDoc era" into the "WebApp era". (Web2.0 is what I consider to be the
    trasitional period between 1999 and web in 2010.) JavaScript was becoming more
    and more prevelant and AJAX was picking up steam. As the "web standards" browsers
    (FireFox, Opera, Safari, ect) started to gain market share and standards compliance
    became a political soapbox everyone started running their site against the W3C
    validator. If you wanted to validate you had to write to the lowest common
    demominator or build multiple versions of your site as we still had this "EXACTLY"
    the same attitude. If I want to round out my corners in FireFox I simply
    call -moz-border-radius. To make this work the same in IE I either have
    to wirte alot of JavaScript or breakout photoshop and start building some
    background images. In hindsite, this "Exactly" the same + W3C validation attitude
    led to the use of the lowest common demominator (to meet compliance) and
    increased development costs (all the workarounds required for "EXACTLY").
    </p>

    <p>
    Fast forward to present day. A collegue and I were wrapping up some loose ends
    on a soon to be launched web application and he is implementing some CSS3 style.
    Nothing to dramatic, some shadowing and background gradiants. In IE we loose
    a little style but no functionality. I questioned the degraded look and feel
    in IE, he simply shrugged his shoulders. This sparked a conversation basically
    covering what I have just written. The end question was why do we write to the
    lowest common denominator? Why are we making FireFox, Chrome, Opera and Safari
    users suffer because IE doesn't want to support something? That got me thinking,
    everything degrades when it runs on an inferior platform. Video game makers
    do not write for legacy hardware, they draw a line in the sand and say we'll
    degrade gracefully back to a certian point. Operating systems do the same,
    look a Windows and Aero. Aero shuts its self off when it encounters a platform
    that can't support it. It does this in order to give the user a better experiance.
    There are countless examples of software degrading to meet the limits of it's
    platform. Sure, the video game will run full tilt on legacy hardware, but
    perfomance starts to suffer creating a poor user experiance. So when the game
    detects a suboptimal platform it degrades. It does this to save the user
    experiance not be "EXACTLY" the same across all configurations. This model
    rewards those who are running the latest/greatest. Why should the web be any
    different?
    </p>

    <p>
    This is a paradigm shift in the way we think about building for the web.
    "Standards compliance" is a great goal but its meaning has been bastardized.
    It's intent is not for a developers final product, rather it is the belief
    that a developer should be able to write once and run any where (and as a
    developer I say ahmen). But that's not reality. The way in which vendor A
    inteprets a W3C recomendation varies from the way vendor B does. Instead of
    thinking my product must meet be defined as "VALIDATED" and "EXACTLY" we should
    think "user experiance".
    </p>

    <p>
    In the end we are building a product. We need to consider our audiance and
    what would give them a better experiance.
    Background images and extra JavaScript will help you meet the "EXACTLY". However,
    "EXACTLY" increases the cost of your product and can hamper performance. (Loading
    images and processing JavaScript requires more resources than the CSS supported
    by your browser). Poor performance is equal to a poor user experiance. Your
    product needs to be fast and functional. Users do not care less how it looks
    or if IE does it just like Chrome. They care about their ability to get, get
    what they need and get out. If catering to abilities of the browser in use
    gives the user a better experiance, is that no better than being able to stand
    on a soapbox and shout "VALIDATES" and "EXACTLY"?
    </p></div>
