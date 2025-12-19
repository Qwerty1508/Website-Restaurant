import { useEffect, useState } from 'react';
import { motion } from 'motion/react';
import { Facebook, Twitter, Instagram, Youtube } from 'lucide-react';
import svgPaths from "../imports/svg-2u60ooooik";

const socialLinks = [
  { icon: Facebook, href: '#', label: 'Facebook' },
  { icon: Twitter, href: '#', label: 'Twitter' },
  { icon: Instagram, href: '#', label: 'Instagram' },
  { icon: Youtube, href: '#', label: 'YouTube' }
];

const quickLinks = [
  'Berita',
  'Galeri',
  'Layanan Publik',
  'Kebijakan Privasi'
];

// Police Radio Visualizer Component
function PoliceRadioVisualizer() {
  const [bars, setBars] = useState<number[]>(Array(20).fill(0));

  useEffect(() => {
    const interval = setInterval(() => {
      setBars(Array(20).fill(0).map(() => Math.random() * 100));
    }, 100);

    return () => clearInterval(interval);
  }, []);

  return (
    <div className="flex items-end gap-1 h-12">
      {bars.map((height, index) => (
        <motion.div
          key={index}
          className="w-2 bg-gradient-to-t from-[#DC143C] via-[#0066CC] to-[#FFD700] rounded-t-full"
          animate={{ height: `${height}%` }}
          transition={{ duration: 0.1 }}
          style={{ minHeight: '4px' }}
        />
      ))}
    </div>
  );
}

export function Footer() {
  return (
    <footer className="relative px-4 md:px-8 lg:px-32 py-16 mt-20">
      {/* Top Border with Animation */}
      <motion.div
        className="absolute top-0 left-0 right-0 h-px"
        initial={{ scaleX: 0 }}
        whileInView={{ scaleX: 1 }}
        viewport={{ once: true }}
        transition={{ duration: 1 }}
        style={{
          background: 'linear-gradient(90deg, transparent 0%, #FFD700 50%, transparent 100%)'
        }}
      />

      <div className="relative border border-white/20 rounded-3xl p-6 md:p-12">
        {/* Glassmorphism Background */}
        <div 
          className="absolute inset-0 rounded-3xl"
          style={{
            background: 'rgba(30, 30, 30, 0.6)',
            backdropFilter: 'blur(20px)'
          }}
        />

        <div className="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
          {/* Column 1: About */}
          <motion.div
            initial={{ y: 50, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
          >
            <h3 className="text-white text-2xl font-bold mb-6">
              Alamat Polsek Merauke
            </h3>
            <div className="space-y-3 text-gray-300">
              <p>Jl. Brawijaya No. 27, Merauke, Papua Selatan</p>
              <p>Telepon: (0971) 123-456</p>
              <p>Email: humas@polresmerauke.go.id</p>
            </div>
          </motion.div>

          {/* Column 2: Quick Links */}
          <motion.div
            initial={{ y: 50, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6, delay: 0.1 }}
          >
            <h3 className="text-white text-2xl font-bold mb-6">
              Tautan Cepat
            </h3>
            <ul className="space-y-3">
              {quickLinks.map((link, index) => (
                <motion.li
                  key={link}
                  initial={{ x: -20, opacity: 0 }}
                  whileInView={{ x: 0, opacity: 1 }}
                  viewport={{ once: true }}
                  transition={{ delay: 0.2 + index * 0.05 }}
                >
                  <motion.a
                    href={`#${link.toLowerCase().replace(/\s+/g, '-')}`}
                    className="text-gray-300 hover:text-[#FFD700] transition-colors inline-block"
                    whileHover={{ x: 10 }}
                  >
                    {link}
                  </motion.a>
                </motion.li>
              ))}
            </ul>
          </motion.div>

          {/* Column 3: Social Media */}
          <motion.div
            initial={{ y: 50, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6, delay: 0.2 }}
          >
            <h3 className="text-white text-2xl font-bold mb-6">
              Media Sosial
            </h3>
            <div className="flex flex-wrap gap-4">
              {socialLinks.map((social, index) => {
                const Icon = social.icon;
                return (
                  <motion.a
                    key={social.label}
                    href={social.href}
                    className="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-[#FFD700] transition-colors group"
                    initial={{ scale: 0, rotate: 0 }}
                    whileInView={{ scale: 1, rotate: 0 }}
                    viewport={{ once: true }}
                    transition={{ delay: 0.3 + index * 0.1, type: "spring" }}
                    whileHover={{
                      scale: 1.2,
                      rotate: 360,
                    }}
                    whileTap={{ scale: 0.9 }}
                  >
                    <Icon 
                      className="w-5 h-5 text-white group-hover:text-[#0A1F44] transition-colors"
                    />
                  </motion.a>
                );
              })}
            </div>

            {/* TikTok SVG Icon */}
            <motion.div
              className="mt-4 inline-block"
              initial={{ scale: 0 }}
              whileInView={{ scale: 1 }}
              viewport={{ once: true }}
              transition={{ delay: 0.7, type: "spring" }}
            >
              <motion.a
                href="#"
                className="w-12 h-12 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-[#FFD700] transition-colors group inline-flex"
                whileHover={{ scale: 1.2, rotate: 360 }}
                whileTap={{ scale: 0.9 }}
              >
                <svg className="w-5 h-5" fill="white" viewBox="0 0 33 33">
                  <path d={svgPaths.p37343700} className="group-hover:fill-[#0A1F44] transition-colors" />
                </svg>
              </motion.a>
            </motion.div>
          </motion.div>

          {/* Column 4: Police Radio Visualizer */}
          <motion.div
            initial={{ y: 50, opacity: 0 }}
            whileInView={{ y: 0, opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6, delay: 0.3 }}
          >
            <h3 className="text-white text-2xl font-bold mb-6">
              Live Police Radio
            </h3>
            <div className="bg-[#0A1F44]/50 backdrop-blur-md rounded-xl p-6 border border-[#0066CC]/30">
              <div className="flex items-center gap-3 mb-4">
                <motion.div
                  className="w-3 h-3 bg-[#DC143C] rounded-full"
                  animate={{
                    opacity: [1, 0.3, 1],
                    scale: [1, 1.2, 1],
                  }}
                  transition={{ duration: 1.5, repeat: Infinity }}
                />
                <span className="text-white font-semibold">ON AIR</span>
              </div>
              <PoliceRadioVisualizer />
              <motion.p
                className="text-gray-400 text-sm mt-4"
                animate={{
                  opacity: [0.5, 1, 0.5],
                }}
                transition={{ duration: 2, repeat: Infinity }}
              >
                Monitoring aktif 24/7
              </motion.p>
            </div>
          </motion.div>
        </div>

        {/* Bottom Section */}
        <motion.div
          className="relative z-10 mt-12 pt-8 border-t border-white/10"
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.6, delay: 0.5 }}
        >
          {/* Marquee Copyright */}
          <div className="overflow-hidden">
            <motion.p
              className="text-gray-400 text-sm text-center whitespace-nowrap"
              animate={{ x: ['100%', '-100%'] }}
              transition={{ duration: 20, repeat: Infinity, ease: "linear" }}
            >
              © 2024 Humas Polres Merauke. All rights reserved. | Melayani dengan Sepenuh Hati | SATU UNTUK LAYANAN
            </motion.p>
          </div>
        </motion.div>
      </div>

      {/* Decorative Elements */}
      <motion.div
        className="absolute top-1/2 left-0 w-64 h-64 bg-[#0066CC] rounded-full opacity-5 blur-3xl"
        animate={{
          scale: [1, 1.2, 1],
          x: [0, 50, 0],
        }}
        transition={{ duration: 8, repeat: Infinity }}
      />
      <motion.div
        className="absolute top-1/3 right-0 w-80 h-80 bg-[#FFD700] rounded-full opacity-5 blur-3xl"
        animate={{
          scale: [1, 1.3, 1],
          x: [0, -50, 0],
        }}
        transition={{ duration: 10, repeat: Infinity }}
      />
    </footer>
  );
}