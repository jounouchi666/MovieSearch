import { describe, it, expect, vi } from 'vitest';
import { searchMovies } from './movieApi';
import LaravelClient from './LaravelClient';

describe('searchMovies', () => {
  it('AbortSignalが渡される', async () => {
    const mockGet = vi.fn().mockResolvedValue({});

    (LaravelClient.getInstance().get as any) = mockGet;

    const controller = new AbortController();

    await searchMovies({
      title: 'test',
      includeAdult: false,
      page: 1,
      signal: controller.signal
    });

    expect(mockGet).toHaveBeenCalledWith(
      '/api/v1/search',
      {
        title: 'test',
        include_adult: false,
        page: 1
      },
      controller.signal
    );
  });
});