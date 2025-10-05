"use client";

import { useEffect, useState } from "react";
import Particles, { initParticlesEngine } from "@tsparticles/react";
import { loadSlim } from "@tsparticles/slim";

export default function ParticlesBackground() {
    const [init, setInit] = useState(false);

    useEffect(() => {
        initParticlesEngine(async (engine) => {
            await loadSlim(engine);
        }).then(() => {
            setInit(true);
        });
    }, []);

    if (!init) return null;

    return (
        <Particles
            id="tsparticles"
            options={{
                fullScreen: { enable: true, zIndex: -1 },
                background: { color: { value: "#0f172a" } },
                fpsLimit: 60,
                interactivity: {
                    events: {
                        onHover: { enable: true, mode: "repulse" },
                        resize: { enable: true }  // ← Desactivado
                    },
                    modes: { repulse: { distance: 100, duration: 0.4 } },
                },
                particles: {
                    color: { value: ["#00ffff","#38bdf8","#3b82f6"] },
                    links: { color: "#38bdf8", distance: 150, enable: true, opacity: 0.3, width: 1 },
                    move: { enable: true, outModes: { default: "bounce" }, speed: 1.5 },
                    number: { density: { enable: true, width: 800, height: 800 }, value: 70 },
                    opacity: { value: 0.6 },
                    shape: { type: "circle" },
                    size: { value: { min: 1, max: 4 } },
                },
                detectRetina: true,
            }}
        />
    );
}