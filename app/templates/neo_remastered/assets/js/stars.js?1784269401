// Реинициализируемый модуль звёздного поля.
// window.stars(canvas?) можно вызывать многократно:
//  - если передан canvas, используется он
//  - если нет, ищется #starfield
//  - при повторном вызове предыдущая анимация отменяется и пересоздаётся
(function(){
    function initStarfield(targetCanvas){
        const c = targetCanvas || document.getElementById('starfield');
        if(!c) return;

        // Останавливаем предыдущую инстанцию если была
        if(c.__starfield && typeof c.__starfield.stop === 'function'){
            c.__starfield.stop();
        }

        const ctx = c.getContext('2d');
        const dpr = window.devicePixelRatio || 1;
        let w, h;
        let stars = [];
        const COUNT = 200;
        let rafId = 0;

        function resize(){
            w = window.innerWidth;
            h = window.innerHeight;
            c.width = w * dpr;
            c.height = h * dpr;
            c.style.width = w + 'px';
            c.style.height = h + 'px';
            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(dpr,dpr);

            stars = [];
            const speedFactor = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--star-speed')) || 1;
            for(let i=0;i<COUNT;i++){
                stars.push({
                    x: Math.random()*w,
                    y: Math.random()*h,
                    size: Math.random()*1.5 + 0.5,
                    speed: (Math.random()*1.1 + 0.3) * speedFactor
                });
            }
        }

        function draw(){
            ctx.clearRect(0,0,w,h);
            const color = getComputedStyle(document.documentElement).getPropertyValue('--stars').trim() || '#fff';
            for(let i=0;i<stars.length;i++){
                const s = stars[i];
                ctx.fillStyle = color;
                ctx.beginPath();
                ctx.arc(s.x, s.y, s.size, 0, Math.PI*2);
                ctx.fill();
                s.y -= s.speed;
                if(s.y < -s.size){
                    s.y = h + s.size;
                    s.x = Math.random()*w;
                }
            }
            rafId = requestAnimationFrame(draw);
        }

        function stop(){
            if(rafId) cancelAnimationFrame(rafId);
            rafId = 0;
            window.removeEventListener('resize', resize);
        }

        window.addEventListener('resize', resize);
        resize();
        draw();

        c.__starfield = { stop, resize };
        return c.__starfield;
    }

    // Экспортируем глобально
    window.stars = initStarfield;
    // Сообщаем что stars доступен
    try { window.dispatchEvent(new CustomEvent('stars:ready')); } catch(e) {}

    // Автоинициализация при загрузке DOM, если есть #starfield
    if(document.readyState === 'loading'){
        document.addEventListener('DOMContentLoaded', function(){ initStarfield(); });
    } else {
        initStarfield();
    }
})();