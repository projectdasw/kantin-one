
const KantinAutoRefresh = {
    start(callback, interval = 10000) {
        if (typeof callback !== 'function') {
            throw new TypeError('Callback auto-refresh harus berupa fungsi.');
        }

        let timer = null;
        let running = false;

        const execute = async () => {
            if (running || document.hidden) {
                return;
            }

            running = true;

            try {
                await callback();
            } catch (error) {
                console.error('Auto-refresh gagal:', error);
            } finally {
                running = false;
            }
        };

        const startTimer = () => {
            if (timer !== null) {
                return;
            }

            timer = window.setInterval(execute, interval);
        };

        const stopTimer = () => {
            if (timer === null) {
                return;
            }

            window.clearInterval(timer);
            timer = null;
        };

        const handleVisibilityChange = () => {
            if (document.hidden) {
                stopTimer();
            } else {
                startTimer();
                execute();
            }
        };

        document.addEventListener('visibilitychange', handleVisibilityChange);

        startTimer();

        return () => {
            stopTimer();
            document.removeEventListener(
                'visibilitychange',
                handleVisibilityChange
            );
        };
    },
};

window.KantinAutoRefresh = KantinAutoRefresh;