{{-- Общая маска +7 и PhoneNormalizer; используется на регистрации и входе --}}
<script>
    document.addEventListener('alpine:init', () => {
        function parseNationalFromInput(raw) {
            const rawTrim = String(raw || '').trim();
            let d = rawTrim.replace(/\D/g, '');
            if (d.length === 0) return '';
            if (rawTrim.startsWith('+7') || rawTrim.startsWith('+ 7')) {
                d = d.replace(/^7/, '');
            }
            d = d.slice(0, 11);
            if (d.length >= 11 && d[0] === '8') {
                d = '7' + d.slice(1);
            }
            if (d.length >= 11 && d[0] === '7') {
                return d.slice(1, 11);
            }
            if (d.length === 10 && d[0] === '8') {
                d = '7' + d.slice(1);
            }
            return d.slice(0, 10);
        }

        function nationalFromSaved(phone) {
            const d = String(phone || '').replace(/\D/g, '').slice(0, 11);
            if (d.length === 11 && d[0] === '7') return d.slice(1);
            if (d.length === 10 && d[0] === '7') return d;
            if (d.length === 10 && d[0] === '8') return '7' + d.slice(1);
            return '';
        }

        function formatNational(national) {
            const n = (national || '').slice(0, 10);
            if (n.length === 0) return '';
            let s = '+7 (' + n.slice(0, 3);
            if (n.length <= 3) return s + (n.length === 3 ? ') ' : '');
            s += ') ' + n.slice(3, 6);
            if (n.length <= 6) return s;
            s += '-' + n.slice(6, 8);
            if (n.length <= 8) return s;
            s += '-' + n.slice(8, 10);
            return s;
        }

        function looksLikeEmailInput(raw) {
            return /[@a-zA-Zа-яА-ЯёЁіІ]/.test(String(raw || ''));
        }

        Alpine.data('registerPhoneMask', (initial) => ({
            display: '',
            phoneCanon: '',

            init() {
                if (initial) {
                    const national = nationalFromSaved(initial);
                    this.display = formatNational(national);
                    this.phoneCanon = national.length === 10 ? '7' + national : '';
                }
            },

            onInput(e) {
                const national = parseNationalFromInput(e.target.value);
                this.display = formatNational(national);
                this.phoneCanon = national.length === 10 ? '7' + national : '';
            },
        }));

        Alpine.data('loginEmailOrPhone', (initial) => ({
            display: '',
            loginValue: '',

            init() {
                const init = initial || '';
                if (init.includes('@') || looksLikeEmailInput(init)) {
                    this.display = init;
                    this.loginValue = init;
                } else {
                    const national = nationalFromSaved(init);
                    this.display = national ? formatNational(national) : '';
                    this.loginValue = national.length === 10 ? '7' + national : init.replace(/\D/g, '');
                }
            },

            onInput(e) {
                const raw = e.target.value;
                if (looksLikeEmailInput(raw)) {
                    this.display = raw;
                    this.loginValue = raw.trim();
                    return;
                }
                const national = parseNationalFromInput(raw);
                this.display = formatNational(national);
                this.loginValue = national.length === 10 ? '7' + national : national;
            },
        }));
    });
</script>
