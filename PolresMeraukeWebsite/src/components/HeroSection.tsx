import { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import imgRectangle2 from "figma:asset/2b95971bdaebb513bb44426be49b09876a44c61d.png";

export function HeroSection() {
  const [typedText, setTypedText] = useState('');
  const fullText = 'SATU UNTUK LAYANAN';

  useEffect(() => {
    let index = 0;
    const interval = setInterval(() => {
      if (index <= fullText.length) {
        setTypedText(fullText.slice(0, index));
        index++;
      } else {
        clearInterval(interval);
      }
    }, 100);

    return () => clearInterval(interval);
  }, []);

  return (
    <motion.section
      className="relative min-h-screen flex items-center justify-center px-4 md:px-8 lg:px-32 pt-24 md:pt-32"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: 1, delay: 0.5 }}
    >
      {/* Background with Glassmorphism */}
      <motion.div
        className="relative w-full max-w-7xl"
        initial={{ scale: 0.9, opacity: 0 }}
        animate={{ scale: 1, opacity: 1 }}
        transition={{ duration: 1, delay: 0.7 }}
      >
        {/* Main Hero Card */}
        <div className="relative rounded-[25px] md:rounded-[40px] overflow-hidden shadow-2xl">
          {/* Background Image with Ken Burns Effect */}
          <motion.div
            className="absolute inset-0"
            animate={{
              scale: [1, 1.1, 1],
            }}
            transition={{ duration: 20, repeat: Infinity, ease: "linear" }}
          >
            <img
              src={imgRectangle2}
              alt="Hero Background"
              className="w-full h-full object-cover"
            />
          </motion.div>

          {/* Gradient Overlay */}
          <div className="absolute inset-0 bg-gradient-to-t from-[rgba(10,31,68,0.95)] via-[rgba(10,31,68,0.6)] to-transparent" />

          {/* Content */}
          <div className="relative z-10 px-6 md:px-12 py-20 md:py-40">
            {/* Typing Animation */}
            <motion.div
              className="mb-12"
              initial={{ y: 50, opacity: 0 }}
              animate={{ y: 0, opacity: 1 }}
              transition={{ delay: 1, duration: 0.8 }}
            >
              <h1 className="text-3xl md:text-6xl lg:text-8xl font-bold text-[#FFD700] mb-4">
                {typedText}
                <motion.span
                  animate={{ opacity: [1, 0, 1] }}
                  transition={{ duration: 0.8, repeat: Infinity }}
                  className="inline-block w-0.5 md:w-1 h-10 md:h-20 bg-[#FFD700] ml-2"
                />
              </h1>
              <motion.p
                className="text-white text-base md:text-2xl"
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ delay: 2.5 }}
              >
                Polres Merauke - Melayani dengan Sepenuh Hati
              </motion.p>
            </motion.div>

            {/* CTA Buttons */}
            <motion.div
              className="flex flex-wrap gap-4 md:gap-6"
              initial={{ y: 50, opacity: 0 }}
              animate={{ y: 0, opacity: 1 }}
              transition={{ delay: 2.7 }}
            >
              <motion.button
                className="relative px-6 md:px-8 py-3 md:py-4 bg-[#0066CC] text-white rounded-full font-semibold overflow-hidden group text-sm md:text-base"
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
              >
                <motion.div
                  className="absolute inset-0 bg-[#FFD700]"
                  initial={{ x: '-100%' }}
                  whileHover={{ x: 0 }}
                  transition={{ duration: 0.3 }}
                />
                <span className="relative z-10 group-hover:text-[#0A1F44] transition-colors">
                  Layanan Darurat
                </span>
                
                {/* Ripple Effect */}
                <motion.div
                  className="absolute inset-0 rounded-full"
                  initial={{ scale: 0, opacity: 0.5 }}
                  whileTap={{ scale: 2, opacity: 0 }}
                  transition={{ duration: 0.5 }}
                  style={{
                    background: 'radial-gradient(circle, rgba(255,215,0,0.8) 0%, transparent 70%)',
                  }}
                />
              </motion.button>

              <motion.button
                className="relative px-6 md:px-8 py-3 md:py-4 border-2 border-white text-white rounded-full font-semibold backdrop-blur-sm overflow-hidden group text-sm md:text-base"
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
              >
                <motion.div
                  className="absolute inset-0 bg-white"
                  initial={{ x: '-100%' }}
                  whileHover={{ x: 0 }}
                  transition={{ duration: 0.3 }}
                />
                <span className="relative z-10 group-hover:text-[#0A1F44] transition-colors">
                  Hubungi Kami
                </span>
              </motion.button>
            </motion.div>
          </div>
        </div>

        {/* Floating Elements */}
        <motion.div
          className="absolute -top-8 -right-8 w-32 h-32 bg-[#FFD700] rounded-full opacity-20 blur-3xl"
          animate={{
            y: [0, -30, 0],
            scale: [1, 1.2, 1],
          }}
          transition={{ duration: 4, repeat: Infinity }}
        />
        <motion.div
          className="absolute -bottom-8 -left-8 w-40 h-40 bg-[#0066CC] rounded-full opacity-20 blur-3xl"
          animate={{
            y: [0, 30, 0],
            scale: [1, 1.3, 1],
          }}
          transition={{ duration: 5, repeat: Infinity }}
        />
      </motion.div>

      {/* Scroll Indicator */}
      <motion.div
        className="absolute bottom-8 md:bottom-12 left-1/2 -translate-x-1/2"
        animate={{ y: [0, 10, 0] }}
        transition={{ duration: 1.5, repeat: Infinity }}
      >
        <div className="flex flex-col items-center gap-2">
          <div className="w-6 h-10 border-2 border-white rounded-full flex items-start justify-center p-2">
            <motion.div
              className="w-1.5 h-1.5 bg-white rounded-full"
              animate={{ y: [0, 16, 0] }}
              transition={{ duration: 1.5, repeat: Infinity }}
            />
          </div>
          <span className="text-white text-sm">Scroll</span>
        </div>
      </motion.div>
    </motion.section>
  );
}