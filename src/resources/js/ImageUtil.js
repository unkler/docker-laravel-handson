import imageCompression from 'browser-image-compression'

export default {
  // 圧縮画像の生成
  async getCompressImageFileAsync(file) {
    const options = {
      maxSizeMB: 1,
      maxWidthOrHeight: 640
    }

    try {
      return await imageCompression(file, options);
    } catch (error) {
      console.error(error)
    }
  }
}

