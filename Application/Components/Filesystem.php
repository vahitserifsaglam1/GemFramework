<?php

    namespace Gem\Components;

    use ArrayObject;
    use Exception;

    class Filesystem
    {


        /**
         * @param mixed $files
         * @return \ArrayObject
         */
        private function toIterator($files)
        {

            if (!$files instanceof \Traversable) {
                $files = new ArrayObject(is_array($files) ? $files : [$files]);
            }

            return $files;
        }


        /**
         * Dosyaya metni girmeye yarar
         *
         * @param string         $data
         * @param mixed          $filename
         * @param boolean|string $append
         * @return boolean
         */
        public function write($filename, $data, $append = false)
        {

            if (!$append) {
                $mode = "w";
            } else {
                $mode = "a";
            }
            if ($handle = fopen($filename, $mode)) {
                fwrite($handle, $data);
                fclose($handle);

                return true;
            }

            return false;
        }


        /**
         * Girilen dosya yolundaki içeriği okur
         *
         * @param string $fileName
         * @param bool   $fread
         * @return string
         * @throws Exception
         */
        public function read($fileName = '', $fread = false)
        {

            if ($this->exists($fileName)) {

                if (false === $fread) {

                    return file_get_contents($fileName);
                } elseif (true === $fread) {

                    $open = fopen($fread, 'r');
                    $read = fgetss($fread, filesize($fileName));
                    fclose($open);

                    return $read;
                }
            } else {

                throw new Exception(
                   sprintf('Girdiğiniz %s dosyası bulunamadı', $fileName)
                );
            }
        }

        public function exists($fileName = '')
        {

            foreach ($this->toIterator($fileName) as $file) {

                if (!file_exists($file)) {
                    return false;
                }
            }

            return true;
        }

        /**
         * $filePath ile girilen yolda bir dosya oluşturur, $over  true girilirse dosya silinip yeni dosya oluştururlu.
         *
         * @param string $filePath
         * @param bool   $over
         * @return bool
         */
        public function touch($filePath = '', $over = false)
        {

            if (false === $over) {

                if (false === $this->exists($filePath)) {

                    return touch($filePath);
                }
            } else {

                if (true === $this->exists($filePath)) {

                    $this->delete($filePath);
                }

                return touch($filePath);
            }
        }

        /**
         * Girilen $dir yolundaki dosyayı siler
         *
         * @param string $dir
         * @return bool
         */
        public function delete($dir = '')
        {

            foreach ($this->toIterator($dir) as $dirs) {

                if (!file_exists($dirs)) {
                    return false;
                }

                if (is_file($dirs)) {

                    if (true !== unlink($dirs)) {

                        continue;
                    }
                } elseif (is_dir($dirs)) {

                    if (true !== rmdir($dirs)) {

                        continue;
                    }
                }
            }

            return true;
        }

        /**
         * $filepath ile girilen yola $mode değişkenindeki izinleri atar
         *
         * @param string $filePath
         * @param int    $mode
         * @return bool
         */
        public function chmod($filePath = '', $mode = 0777)
        {

            if (true === $this->exists($filePath)) {

                return chmod($filePath, $mode);
            }
        }

        /**
         * Dosya Kopyalama İşlemini yapar
         *
         * @param string $src
         * @param string $desc
         * @throws Exception
         */
        public function copy($src = '', $desc = '')
        {

            if (!is_file($src)) {

                throw new Exception(
                   sprintf('girdiğiniz %s bir dosya değil', $src));
            }

            $this->mkdir($desc);

            if (true !== copy($src, $desc)) {

                $error = error_get_last();
                throw new Exception(
                   sprintf('Dosya kopyalama sırasında bir hata oluştu: %s', $error['message'])
                );
            }
        }


        /**
         * Girilen $dir değişkenine göre yeni bir dosya oluşturur
         *
         * @param string $dir
         * @param int    $mode
         * @throws Exception
         * @return bool
         */
        public function mkdir($dir = '', $mode = 0777)
        {

            foreach ($this->toIterator($dir) as $dirs) {

                if (is_dir($dirs)) {
                    continue;
                }

                if (true !== mkdir($dir, $mode, true)) {

                    $error = error_get_last();
                    throw new Exception(sprintf(
                       'Dosya oluşturma sırasında bir hata oluştu, hata : %s', $error['message']
                    ));
                }

                return true;
            }
        }

        /**
         * Dosyaya yeni bir isim veri
         *
         * @param string $oldFile
         * @param string $newName
         * @throws Exception
         * @return bool
         */
        public function reName($oldFile = '', $newName = '')
        {

            foreach ($this->toIterator($oldFile) as $file) {

                if (false === $this->exists($file)) {
                    continue;
                }

                if (false === rename($oldFile, $newName)) {

                    $error = error_get_last();
                    throw new Exception(
                       sprintf('İsim değiştirme işlemi sırasında bir hata oluştu: %s', $error['message'])
                    );
                }
            }

            return true;
        }

        /**
         * Yeni bir örnek oluşturur
         *
         * @return static
         */
        public static function getInstance()
        {

            return new static();
        }

        /**
         * Girilen parametre ve dosya ile include işlemi yapar
         *
         * @param       $fileName
         * @param array $parametres
         * @return mixed
         */
        public function inc($fileName, $parametres = [])
        {

            if (true === $this->exists($fileName)) {

                if (count($parametres) > 0) {
                    extract($parametres);
                }

                return include($fileName);
            }
        }
    }
