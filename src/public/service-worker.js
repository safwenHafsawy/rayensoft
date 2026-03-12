/*
  Service Worker: Web Push and Notification Click Handling

  What this script does
  - Listens for incoming Push API messages ("push" events) sent from your server via a push service.
  - Displays a system notification using the Notification API.
  - When the user clicks the notification, opens a browser window/tab to a URL carried with the notification.

  Key concepts
  - self: The global scope for the service worker (like window in pages, but for SW context).
  - event.waitUntil(promise): Keeps the service worker alive until the given promise settles, ensuring async work completes.
  - self.registration.showNotification(title, options): Shows a system-level notification.
  - notification.data: Arbitrary data you attach to a notification; here, we store the destination URL.
  - clients.openWindow(url): Opens a new top-level browsing context at the given URL (or focuses if possible in some UAs).
*/


self.addEventListener("push", function (event) {

    if (!event.data) return;

    const data = event.data.json();

    const title = data.title || "Notification";
    const options = {
        body: data.body ||'No Body',
        data: {
            workSessionId : data.workSessionId
        }, // store URL you want to open later
        icon : '/fulllogo.png',
        actions: data.actions
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener("notificationclick", (event) => {
    event.notification.close(); // close the notification popup

    const workSessionId = event.notification.data?.workSessionId;
    const action = event.action; // "confirm" if button clicked, "" if body clicked

    console.log("Notification data:", event.notification.data);
    console.log("Action clicked:", action);

    // Async API call to confirm session
    async function confirmNotification(workSessionId) {
        if (!workSessionId) {
            console.warn("No workSessionId found in notification data.");
            return;
        }

        try {
            await fetch("/api/confirm-focus", {
                method: "PUT", // or POST depending on your route
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ workSessionId: workSessionId }),
            });
            console.log(`Session ${workSessionId} confirmed by user.`);
        } catch (err) {
            console.error("Failed to confirm session:", err);
        }
    }

    // Handle both action button click and body click
    if (action === "confirm" || action === "") {
        event.waitUntil(confirmNotification(workSessionId));
    }
});
