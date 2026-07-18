import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
    scenarios: {
        war_pembeli: {
            executor: 'constant-vus',
            vus: 50,
            duration: '10s',
            exec: 'beliTiket',
        },
    },
};

export function beliTiket() {
    const url = 'http://127.0.0.1:8000/event/8/checkout-form'; 
    
    const payload = JSON.stringify({
        tickets: {
            '19': 1 
        }
    });

    const params = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    };

    const res = http.post(url, payload, params);

    check(res, {
        'SUKSES AMANKAN SLOT (200)': (r) => r.status === 200,
        
        'GAGAL TIKET HABIS (422)': (r) => r.status === 422,
        
        'TERBLOKIR RATE LIMIT (429)': (r) => r.status === 429,
    });

    sleep(0.5); 
}