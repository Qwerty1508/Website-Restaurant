import { useState, useEffect } from 'react';
import { motion, useScroll, useTransform, useMotionValue, useSpring } from 'motion/react';
import { Search, Menu, X } from 'lucide-react';
import imgOip2 from "figma:asset/4c21dcfd9ac02c7253066532a5ef18b5ea66a5b3.png";

const navItems = ['Profil', 'Galeri', 'Layanan', 'Kontak'];

export function Header() {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [hoveredItem, setHoveredItem] = useState<string | null>(null);
  const { scrollY } = useScroll();
  
  const headerHeight = useTransform(scrollY, [0, 100], [96, 72]);
  const headerBg = useTransform(
    scrollY,
    [0, 50],
    ['rgba(242, 244, 247, 0.95)', 'rgba(242, 244, 247, 0.98)']
  );

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  return (
    <>
      <motion.header
        className="fixed top-0 left-0 right-0 z-50 px-4 md:px-8 lg:px-32 pt-4 md:pt-8"
        initial={{ y: -100, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        transition={{ duration: 0.8, ease: [0.4, 0.0, 0.2, 1] }}
        style={{ perspective: '1000px' }}
      >
        <motion.div
          className="relative rounded-[20px] md:rounded-[30px] backdrop-blur-xl shadow-lg overflow-hidden"
          style={{
            height: headerHeight,
            backgroundColor: headerBg,
          }}
        >
          <div className="flex items-center justify-between h-full px-8">
            {/* Logo & Brand - Clickable to scroll to top */}
            <motion.button
              className="flex items-center gap-4 cursor-pointer bg-transparent border-none p-0"
              onClick={() => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
              }}
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
              transition={{ duration: 0.3 }}
            >
              <motion.div
                className="relative w-12 h-12"
                animate={{
                  scale: [1, 1.1, 1],
                  rotate: [0, 5, -5, 0],
                }}
                transition={{ duration: 2, repeat: Infinity, ease: "easeInOut" }}
              >
                <img 
                  src={imgOip2} 
                  alt="Logo Polres" 
                  className="w-full h-full object-contain"
                />
              </motion.div>
              <div>
                <motion.p
                  className="text-[#0A1F44] font-bold text-base drop-shadow-sm"
                  style={{ textShadow: 'rgba(0,0,0,0.25) 0px 4px 4px' }}
                >
                  Polres Merauke
                </motion.p>
              </div>
            </motion.button>

            {/* Desktop Navigation with Advanced Animations */}
            <nav className="hidden lg:flex items-center gap-8">
              {navItems.map((item, index) => (
                <NavItemAnimated 
                  key={item} 
                  item={item} 
                  index={index}
                  isHovered={hoveredItem === item}
                  onHover={() => setHoveredItem(item)}
                  onLeave={() => setHoveredItem(null)}
                />
              ))}

              {/* Search Icon */}
              <motion.button
                className="p-2 rounded-full hover:bg-[rgba(0,102,204,0.1)] transition-colors"
                whileHover={{ scale: 1.1, rotate: 90 }}
                whileTap={{ scale: 0.95 }}
              >
                <Search className="w-5 h-5 text-[#0A1F44]" />
              </motion.button>
            </nav>

            {/* Mobile Menu Button */}
            <motion.button
              className="lg:hidden p-2"
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              whileTap={{ scale: 0.95 }}
            >
              <motion.div
                animate={{ rotate: isMobileMenuOpen ? 180 : 0 }}
                transition={{ duration: 0.3 }}
              >
                {isMobileMenuOpen ? (
                  <X className="w-6 h-6 text-[#0A1F44]" />
                ) : (
                  <Menu className="w-6 h-6 text-[#0A1F44]" />
                )}
              </motion.div>
            </motion.button>
          </div>
        </motion.div>
      </motion.header>

      {/* Mobile Menu */}
      <motion.div
        className="fixed inset-0 z-40 lg:hidden"
        initial={{ opacity: 0, pointerEvents: 'none' }}
        animate={{
          opacity: isMobileMenuOpen ? 1 : 0,
          pointerEvents: isMobileMenuOpen ? 'auto' : 'none',
        }}
        transition={{ duration: 0.3 }}
      >
        <motion.div
          className="absolute inset-0 bg-black/50 backdrop-blur-sm"
          onClick={() => setIsMobileMenuOpen(false)}
        />
        
        <motion.div
          className="absolute top-20 md:top-24 right-4 md:right-8 bg-[#F5F7FA] rounded-3xl p-6 md:p-8 shadow-2xl"
          initial={{ x: 300, opacity: 0 }}
          animate={{
            x: isMobileMenuOpen ? 0 : 300,
            opacity: isMobileMenuOpen ? 1 : 0,
          }}
          transition={{ duration: 0.4, ease: [0.4, 0.0, 0.2, 1] }}
        >
          <nav className="flex flex-col gap-4 md:gap-6">
            {navItems.map((item, index) => (
              <motion.a
                key={item}
                href={`#${item.toLowerCase()}`}
                className="text-[#0A1F44] font-semibold text-base md:text-lg"
                initial={{ x: 50, opacity: 0 }}
                animate={{
                  x: isMobileMenuOpen ? 0 : 50,
                  opacity: isMobileMenuOpen ? 1 : 0,
                }}
                transition={{ delay: index * 0.1 }}
                onClick={() => setIsMobileMenuOpen(false)}
                whileHover={{ x: 10, color: '#0066CC' }}
              >
                {item}
              </motion.a>
            ))}
          </nav>
        </motion.div>
      </motion.div>
    </>
  );
}

// Advanced Navigation Item Component
interface NavItemAnimatedProps {
  item: string;
  index: number;
  isHovered: boolean;
  onHover: () => void;
  onLeave: () => void;
}

function NavItemAnimated({ item, index, isHovered, onHover, onLeave }: NavItemAnimatedProps) {
  const mouseX = useMotionValue(0);
  const mouseY = useMotionValue(0);
  
  const rotateX = useSpring(useTransform(mouseY, [-50, 50], [2, -2]), { stiffness: 100, damping: 10 });
  const rotateY = useSpring(useTransform(mouseX, [-50, 50], [-2, 2]), { stiffness: 100, damping: 10 });

  const handleMouseMove = (e: React.MouseEvent<HTMLAnchorElement>) => {
    const rect = e.currentTarget.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + rect.height / 2;
    mouseX.set(e.clientX - centerX);
    mouseY.set(e.clientY - centerY);
  };

  const handleMouseLeave = () => {
    mouseX.set(0);
    mouseY.set(0);
    onLeave();
  };

  return (
    <motion.a
      href={`#${item.toLowerCase()}`}
      className="relative cursor-pointer group"
      initial={{ y: -20, opacity: 0 }}
      animate={{ y: 0, opacity: 1 }}
      transition={{ delay: index * 0.1 + 0.3 }}
      onMouseMove={handleMouseMove}
      onMouseEnter={onHover}
      onMouseLeave={handleMouseLeave}
      style={{
        rotateX,
        rotateY,
        transformStyle: 'preserve-3d',
      }}
    >
      {/* Background Pulse Effect */}
      <motion.div
        className="absolute inset-0 -z-10 rounded-lg"
        initial={{ scale: 0, opacity: 0 }}
        animate={isHovered ? {
          scale: [0, 1.5, 1.2],
          opacity: [0, 0.25, 0.25],
        } : {
          scale: 0,
          opacity: 0,
        }}
        transition={{ duration: 0.4, ease: [0.4, 0.0, 0.2, 1] }}
        style={{
          background: 'radial-gradient(circle 200px at center, rgba(0,102,204,0.15), transparent)',
        }}
      />

      {/* Text with Morphing Effect */}
      <motion.span
        className="relative block px-2 py-1"
        animate={{
          color: isHovered 
            ? ['#2C3E50', '#0066CC', '#FFD700'] 
            : '#0A1F44',
          fontWeight: isHovered ? 600 : 600,
          letterSpacing: isHovered ? '0.5px' : '0px',
          textShadow: isHovered 
            ? '0 2px 4px rgba(255,215,0,0.3)' 
            : '0 0 0 rgba(0,0,0,0)',
        }}
        transition={{ 
          duration: 0.25,
          color: { times: [0, 0.5, 1], duration: 0.45 },
        }}
      >
        {item}
      </motion.span>

      {/* Gradient Underline with Glow */}
      <motion.div
        className="absolute -bottom-1 left-1/2 h-1 rounded-full"
        style={{
          background: 'linear-gradient(90deg, #0066CC 0%, #FFD700 100%)',
          boxShadow: '0 0 12px rgba(0,102,204,0.6)',
          x: '-50%',
        }}
        initial={{ scaleX: 0, opacity: 0 }}
        animate={{
          scaleX: isHovered ? 1 : 0,
          opacity: isHovered ? 1 : 0,
        }}
        transition={{ 
          duration: isHovered ? 0.3 : 0.2, 
          ease: [0.4, 0.0, 0.2, 1],
        }}
      />

      {/* 3D Depth Shadow */}
      <motion.div
        className="absolute inset-0 -z-20 rounded-lg"
        animate={{
          boxShadow: isHovered
            ? '0 10px 30px rgba(0,102,204,0.2)'
            : '0 5px 15px rgba(0,0,0,0.1)',
        }}
        transition={{ duration: 0.3 }}
      />
    </motion.a>
  );
}