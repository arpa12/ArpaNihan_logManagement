export function logActivity(action, message = '', module = '') {
    const currentUrl = window.location.href;
    if (currentUrl.includes('/activity-log')) return; // prevent recursion

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const userId = document.querySelector('meta[name="user-id"]')?.content;
    const userName = document.querySelector('meta[name="user-name"]')?.content;
    const userRole = document.querySelector('meta[name="user-role"]')?.content;

    const moduleName = module || currentUrl.split('/')[3] || 'Dashboard';

    if (!userId || !userName || !csrf) return;

    const payload = {
        user_id: userId,
        user_name: userName,
        user_role: userRole,
        action,
        message,
        module: moduleName,
        url: currentUrl,
    };

    fetch('/log-activity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify(payload)
    }).catch(console.error);
}
