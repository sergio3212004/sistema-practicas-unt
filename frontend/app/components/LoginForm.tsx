"use client";

import { useState } from "react";
import { Eye, EyeOff, Mail, Lock, AlertCircle, Loader2 } from "lucide-react";

export default function LoginForm() {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [showPassword, setShowPassword] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState("");

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setError("");

        if (!email.endsWith("@unitru.edu.pe")) {
            setError("Por favor, ingrese un correo institucional válido.");
            return;
        }

        setIsLoading(true);

        try {
            const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/login/`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                credentials: "include", // Importante para enviar/recibir cookies
                body: JSON.stringify({
                    email: email, // o 'email' según tu API
                    password: password,
                }),
            });

            const data = await response.json();

            if (response.ok && data.Success) {
                // Login exitoso - redirigir o actualizar estado
                console.log("Login exitoso");
                window.location.href = "/dashboard"; // Ajusta según tu ruta
            } else {
                setError(data.error || "Credenciales incorrectas");
            }
        } catch (err) {
            setError("Error de conexión. Verifica tu red o el servidor.");
            console.error("Error:", err);
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <div className="relative h-screen flex items-center justify-center overflow-hidden">

            {/* Formulario */}
            <div className="relative z-10 w-full max-w-md px-6">
                <form
                    onSubmit={handleSubmit}
                    className="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-2xl"
                >
                    {/* Header */}
                    <div className="text-center mb-8">
                        <div className="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 mb-4">
                            <Lock className="w-8 h-8 text-white" />
                        </div>
                        <h1 className="text-3xl font-bold text-white mb-2">
                            Sistema de Prácticas Preprofesionales
                        </h1>
                        <p className="text-gray-300 text-sm">
                             Informática - UNT
                        </p>
                    </div>

                    {/* Error Alert */}
                    {error && (
                        <div className="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/50 flex items-start gap-3">
                            <AlertCircle className="w-5 h-5 text-red-400 flex-shrink-0 mt-0.5" />
                            <p className="text-red-200 text-sm">{error}</p>
                        </div>
                    )}

                    {/* Email Input */}
                    <div className="mb-5">
                        <label
                            htmlFor="email"
                            className="block text-sm font-medium text-gray-200 mb-2"
                        >
                            Correo Institucional
                        </label>
                        <div className="relative">
                            <Mail className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                            <input
                                id="email"
                                type="email"
                                placeholder="ejemplo@unitru.edu.pe"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                required
                                disabled={isLoading}
                                className="w-full pl-11 pr-4 py-3 rounded-xl bg-white/10 border border-white/20 placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition disabled:opacity-50 disabled:cursor-not-allowed"
                            />
                        </div>
                    </div>

                    {/* Password Input */}
                    <div className="mb-6">
                        <label
                            htmlFor="password"
                            className="block text-sm font-medium text-gray-200 mb-2"
                        >
                            Contraseña
                        </label>
                        <div className="relative">
                            <Lock className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                            <input
                                id="password"
                                type={showPassword ? "text" : "password"}
                                placeholder="••••••••"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                                disabled={isLoading}
                                className="w-full pl-11 pr-12 py-3 rounded-xl bg-white/10 border border-white/20 placeholder-gray-400 text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition disabled:opacity-50 disabled:cursor-not-allowed"
                            />
                            <button
                                type="button"
                                onClick={() => setShowPassword(!showPassword)}
                                disabled={isLoading}
                                className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-300 transition disabled:opacity-50"
                            >
                                {showPassword ? (
                                    <EyeOff className="w-5 h-5" />
                                ) : (
                                    <Eye className="w-5 h-5" />
                                )}
                            </button>
                        </div>
                    </div>

                    {/* Forgot Password */}
                    <div className="mb-6 text-right">
                        <a
                            href="#"
                            className="text-sm text-cyan-400 hover:text-cyan-300 transition"
                        >
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    {/* Submit Button */}
                    <button
                        type="submit"
                        disabled={isLoading}
                        className="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-400 hover:to-blue-400 text-white font-semibold py-3 rounded-xl transition duration-300 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg shadow-cyan-500/50"
                    >
                        {isLoading ? (
                            <>
                                <Loader2 className="w-5 h-5 animate-spin" />
                                Ingresando...
                            </>
                        ) : (
                            "Ingresar al Sistema"
                        )}
                    </button>

                    {/* Footer */}
                    <div className="mt-6 text-center text-sm text-gray-400">
                        <p>
                            ¿Problemas para acceder?{" "}
                            <a href="#" className="text-cyan-400 hover:text-cyan-300">
                                Contactar soporte
                            </a>
                        </p>
                    </div>
                </form>

                {/* Info adicional */}
                <div className="mt-6 text-center text-xs text-gray-400">
                    <p>© 2025 Universidad Nacional de Trujillo</p>
                    <p className="mt-1">Escuela de Informática</p>
                </div>
            </div>
        </div>
    );
}