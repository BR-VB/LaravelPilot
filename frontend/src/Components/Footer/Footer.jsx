import React from 'react';

export default function Footer() {
    const reactVersion = React.version;

    return (
        <footer>
            <div className="text-gray-400 mt-10">React ({reactVersion}) | Vite (3.4.17) | Tailwind (6.0.7) | ProjectNavigator - API (1.0.0) </div>
        </footer>
    );
}
